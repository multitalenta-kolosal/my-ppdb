<?php

namespace Modules\Registrant\Services;

use Modules\Registrant\Services\RegistrantStageService;
use Modules\Message\Services\RegistrantMessageService;
use Modules\Message\Services\MessageService;

use Modules\Registrant\Repositories\RegistrantRepository;
use Modules\Registrant\Repositories\RegistrantStageRepository;
use Modules\Message\Repositories\RegistrantMessageRepository;
use Modules\Finance\Repositories\InstallmentRepository;
use Modules\Core\Repositories\UnitRepository;
use Modules\Core\Repositories\PeriodRepository;
use Modules\Core\Repositories\PathRepository;
use Modules\Core\Repositories\TierRepository;

use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Modules\Registrant\Events\Backend\RegistrantCreated;
use Modules\Registrant\Events\Frontend\RegistrantEnlist;

class RegistrantService{

    protected $registrantMessageService;
    protected $registrantStageService;
    protected $messageService;

    protected $registrantRepository;
    protected $unitRepository;
    protected $periodRepository;
    protected $pathRepository;
    protected $tierRepository;
    protected $installmentRepository;

    public function __construct(
        /**
         * Services Parameter
         * 
         */
        RegistrantMessageService $registrantMessageService,
        RegistrantStageService $registrantStageService,
        MessageService $messageService,
        /**
         * Repositories Parameter
         * 
         */
        PathRepository $pathRepository,
        RegistrantRepository $registrantRepository,
        RegistrantStageRepository $registrantStageRepository,
        RegistrantMessageRepository $registrantMessageRepository,
        UnitRepository $unitRepository,
        PeriodRepository $periodRepository,
        TierRepository $tierRepository,
        InstallmentRepository $installmentRepository
    ) {
        /**
         * Services Declaration
         * 
         */
        $this->registrantMessageService = $registrantMessageService;
        $this->registrantStageService = $registrantStageService;
        $this->messageService = $messageService;
        /**
         * Repositories Declaration
         * 
         */
        $this->pathRepository = $pathRepository;
        $this->registrantRepository = $registrantRepository;
        $this->registrantStageRepository = $registrantStageRepository;
        $this->registrantMessageRepository = $registrantMessageRepository;
        $this->unitRepository = $unitRepository;
        $this->periodRepository = $periodRepository;
        $this->tierRepository = $tierRepository;
        $this->installmentRepository = $installmentRepository;

        $this->module_title = Str::plural(class_basename($this->registrantRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $registrant =$this->registrantRepository
                    ->all()
                    ->sortByDesc('created_at');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrant,
        );
    }

    public function create(){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $createOptions = $this->prepareOptions();

        return $createOptions;
    }

    public function store(Request $request){

        $data = $request->all();

        DB::beginTransaction();

        try {
            $registrant = $this->registrantRepository->make($data);

            $unit_id = $registrant->unit_id;

            if(!$registrant->registrant_id)
            {
                $registrant_id = $this->generateId($unit_id);
                $registrant->registrant_id = $registrant_id['id'];
            }

            if(!$registrant->va_number)
            {
                $va_number = setting('va_prefix').$registrant->registrant_id;
                $registrant->va_number = $va_number;
            }

            $registrant->unit_increment = $this->generateUnitIncrement($unit_id);
            $registrant->period_id = $this->periodRepository->findActivePeriodId();
            $registrant->register_ip = request()->getClientIP();

            $registrant_stage = $this->registrantStageService->store($request, $registrant);

            $registrant->progress_id = $registrant_stage->data->id;

            $registrant = $this->registrantRepository->create($registrant->toArray());

            $registrant_message = $this->registrantMessageService->store($request, $registrant);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> $registrant,
            );
        }

        DB::commit();

        $response = $this->messageService->send($registrant, 'register-message', 'register');

        if($response->error){
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Send Message error: '.$response->message);
            return (object) array(
                'error'=> true,
                'message'=> $response->message,
                'data'=> $registrant,
            );
        }

        if (Auth::check()) {
            Log::info(label_case($this->module_title.' '.__function__)." | '".$registrant->name.'(ID:'.$registrant->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');
            event(new RegistrantCreated($registrant));
        }else{
            Log::info(label_case($this->module_title.' '.__function__)." | '".$registrant->name.'(ID:'.$registrant->id.") ' by User: Guest)'");
            event(new RegistrantEnlist($registrant));
        }

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrant,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');
 
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->registrantRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $registrant = $this->registrantRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$registrant->name.'(ID:'.$registrant->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrant,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{
            $registrant_check = $this->registrantRepository->findOrFail($id);
     
            $registrant = $this->registrantRepository->make($data);

            if(!$registrant->internal){
                $registrant->internal = false;
            }

            $updated = $this->registrantRepository->update($registrant->toArray(),$id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage()); 
            return (object) array(
                'error'=> true,            
                'message'=> $e->getMessage(),
                'data'=>  null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrant_check->name.'(ID:'.$registrant_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=>  $this->registrantRepository->find($id),
        );  
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $registrants = $this->registrantRepository->findOrFail($id);
    
            $deleted = $this->registrantRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,            
                'message'=> $e->getMessage(),
                'data'=>  null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrants->name.', ID:'.$registrants->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrants,
        );  
    }

    public function purge($id){
        DB::beginTransaction();

        try{
            $registrants = $this->registrantRepository->findTrash($id);
    
            $deleted = $this->registrantRepository->purge($id);

            $deleted = $this->registrantStageRepository->delete($registrants->progress_id);

            $deleted = $this->registrantMessageRepository->delete($registrants->registrant_message->id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrants->name.', ID:'.$registrants->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrants,
        );
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->registrantRepository->trashed(),
        ); 
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $registrants= $this->registrantRepository->restore($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,            
                'message'=> $e->getMessage(),
                'data'=>  null,
            );
        }

        DB::commit();

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$registrants->name.", ID:".$registrants->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=>  $registrants,
        );
    }
    public function prepareFilterOptions(){
        
        $unit = $this->unitRepository->query()->orderBy('order','asc')->pluck('name','id');

        if(!$unit){
            $unit = ['Silakan membuat unit'];
        }

        $type = $this->pathRepository->pluck('name','id');

        $tier = $this->tierRepository->pluck('tier_name','id');

        $installment = $this->installmentRepository->pluck('name','id');

        $stages   =  array_merge(config('stages.progress'),config('stages.special-status'));

        $status = Arr::pluck($stages,'pass-title','status_id');

        $options = array(
            'unit' => $unit,
            'type' => $type,
            'tier' => $tier,
            'status' => $status,
            'installment' => $installment,
        );

        return $options;
    }

    public function prepareOptions(){
        
        $unit = $this->unitRepository->query()->orderBy('order','asc')->pluck('name','id');

        if(!$unit){
            $unit = ['Silakan membuat unit'];
        }

        $type = [];

        $type = $this->pathRepository->query()->pluck('name','id');

        $tier = [];

        $tier = $this->tierRepository->query()->pluck('tier_name','id');

        $options = array(
            'unit' => $unit,
            'type' => $type,
            'tier' => $tier,
        );

        return $options;
    }

    public function getUnits(){
        
        $units = $this->unitRepository->query()->orderBy('order','asc')->get();

        if(!$units){
            $units = ['Silakan membuat unit'];
        }

        return $units;
    }

    public function generateId($unit_id){
        if(!$unit_id){
            return $response = [
                'id'   => null,
                'error' => true,
                'message' => '',
            ];
        }

        $unit = $this->unitRepository->findOrFail($unit_id);

        if($unit->unit_code){
            $unit_code = $unit->unit_code;
        }else{
            $unit_code = "--";
        }

        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        $unit_increment_numeric = $this->generateUnitIncrement($unit_id);

        $unit_increment = sprintf('%03d', $unit_increment_numeric);

        $response = [
            'id'   => $unit_code.$year.$month.$unit_increment,
            'error' => false,
            'message' => '',
        ];
    
        return $response;
    }

    public function generateUnitIncrement($unit_id){

        $max_increment = $this->registrantRepository->getBiggestUnitIncrement($unit_id);

        if($max_increment){
            $increment = $max_increment+1;
        }else{
            $increment = 1;
        }

        return $increment;
    }

    public function track(Request $request){
        $data = $request->all();
        
        DB::beginTransaction();

        try {
            $registrant = $this->registrantRepository->findWhere([
                'registrant_id' => $data['registrant_id'],
                'phone' => $data['phone'],
            ])->first();

            if(!$registrant){
                return (object) array(
                    'error'=> true,
                    'message'=> 'Pendaftar Tidak Ditemukan',
                    'data'=> null,
                );            }
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$registrant->name.'(ID:'.$registrant->id.") IP: ".request()->getClientIp()."'' ");
            
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrant,
        );
    }

    public function purgeAll($all = false){
        DB::beginTransaction();

        try{
            if($all){
                $trashedDatas = $this->registrantRepository->all();
            }else{
                $trashedDatas = $this->registrantRepository->trashed();
            }

            foreach($trashedDatas as $trashedData){
                $purged = $this->registrantRepository->purge($trashedData->id);

                if($this->registrantStageRepository->find($trashedData->progress_id)){
                    $purged = $this->registrantStageRepository->delete($trashedData->progress_id);
                }

                if($this->registrantMessageRepository->find($trashedData->registrant_message->id)){
                    $purged = $this->registrantMessageRepository->delete($trashedData->registrant_message->id);
                }

            }

        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' AT '.Carbon::now().' '.__FUNCTION__)." | by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> null,
        );
    }
}
<?php

namespace Modules\Registrant\Services;

use Modules\Registrant\Services\RegistrantStageService;
use Modules\Message\Services\RegistrantMessageService;
use Modules\Message\Services\MessageService;

use Modules\Registrant\Repositories\RegistrantRepository;
use Modules\Core\Repositories\UnitRepository;
use Modules\Core\Repositories\PeriodRepository;

use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        RegistrantRepository $registrantRepository,
        UnitRepository $unitRepository,
        PeriodRepository $periodRepository
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
        $this->registrantRepository = $registrantRepository;
        $this->unitRepository = $unitRepository;
        $this->periodRepository = $periodRepository;

        $this->module_title = Str::plural(class_basename($this->registrantRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $registrant =$this->registrantRepository
                    ->all()
                    ->sortByDesc('created_at');

        return $registrant;
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

            $registrant->progress_id = $registrant_stage['data']->id;

            $registrant = $this->registrantRepository->create($registrant->toArray());

            $registrant_message = $this->registrantMessageService->store($request, $registrant);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $response['message'],
                'data'=> $registrant,
            );
        }

        DB::commit();

        $response = $this->messageService->send($registrant, 'pendaftaran-contoh', 'register',['name' => $registrant->name, 'unit' => $registrant->unit->name]);

        if($response['error']){
            Log::critical('Send Message error: '.$response['message']);
            return (object) array(
                'error'=> true,
                'message'=> $response['message'],
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

        return $this->registrantRepository->findOrFail($id);
    }

    public function edit($id){

        $registrant = $this->registrantRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$registrant->name.'(ID:'.$registrant->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrant;
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
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrant_check->name.'(ID:'.$registrant_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->registrantRepository->find($id);

    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $registrants = $this->registrantRepository->findOrFail($id);
    
            $deleted = $this->registrantRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrants->name.', ID:'.$registrants->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrants;
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->registrantRepository->trashed();
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $registrants= $this->registrantRepository->restore($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$registrants->name.", ID:".$registrants->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrants;
    }

    public function prepareOptions(){
        
        $unit = $this->unitRepository->query()->orderBy('order','asc')->pluck('name','id');

        if(!$unit){
            $unit = ['Silakan membuat unit'];
        }

        $type = [
            'prestasi' => 'Prestasi',
            'reguler' => 'Reguler',
        ];

        $options = array(
            'unit' => $unit,
            'type' => $type,
        );

        return $options;
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
}
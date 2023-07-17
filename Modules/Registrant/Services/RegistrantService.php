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

use Modules\Registrant\Jobs\CreateVaBySFTP;

use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

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
                    ->findby('period_id',$this->periodRepository->findActivePeriodId())
                    ->sortByDesc('created_at');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrant,
        );
    }


    public function getSchoolList($name){
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-sekolah-indonesia.vercel.app/sekolah/s?sekolah=$name",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            return null;
        } else {
            $data_whole = json_decode($response);
            $datas = $data_whole->dataSekolah;
            $array_data = array();
            foreach ($datas as $data) {
                $array[$data->sekolah] = $data->sekolah;
            }
            \Log::debug(json_encode($array_data));
            return $array_data;
        }
    }
    

    public function create(){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $createOptions = $this->prepareOptions();

        return $createOptions;
    }

    public function store(Request $request){

        $data = $request->all();

        $registrant = $this->registrantRepository->make($data);

        $checkduplicate = $this->registrantRepository->findWhere([
            'name' => $data['name'],
            'unit_id' => $data['unit_id'],
            'period_id' => $this->periodRepository->findActivePeriodId(),
            'email' => $data['email'],
            'type' => $data['type'],
            'phone' => $data['phone'],
        ])->first();

        if($checkduplicate){
            return (object) array(
                'error'=> false,
                'message'=> "Data Pendaftaran Anda sudah terdaftar",
                'data'=> $registrant,
            );
        }

        DB::beginTransaction();

        try {

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

            // $register_info_array = explode(",",setting('register_info'));
            // $registrant->info = $register_info_array[$registrant->info];

            $registrant_stage = $this->registrantStageService->store($request, $registrant);

            $registrant->progress_id = $registrant_stage->data->id;

            $registrant = $this->registrantRepository->create($registrant->toArray());

            $registrant_message = $this->registrantMessageService->store($request, $registrant);
            
            if(setting('create_va_sftp')){
                if(env('SFTP_HOST')){
                    // $sftp_push = \Storage::disk('sftp')->put('89955_'.$registrant->va_number.'.txt', $this->composeTxtContent($registrant));
                    // \Log::info(label_case('CreateVaBySFTP AT '.Carbon::now().' | Function: Store to MFT | Msg: '.json_encode($sftp_push)));

                    $sendToSFTP = new CreateVaBySFTP($registrant);
                    dispatch($sendToSFTP);
                }
            }

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

        $period = null;

        $period = $this->periodRepository->findOrFail($this->periodRepository->findActivePeriodId());

        $options = array(
            'unit' => $unit,
            'type' => $type,
            'tier' => $tier,
            'period' => $period,
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
        DB::beginTransaction();

        try {
            $max_increment = $this->registrantRepository->getBiggestUnitIncrement($unit_id);

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

    public function composeTxtContent($registrant){

        $va = $registrant->va_number;
        $name = $registrant->name;
        $unit_name = $registrant->unit->name;
        $open_date = Carbon::now()->format('Ymd');
        $close_date = Carbon::now()->addYears(7)->format('Ymd'); //change to year
        $bill = $this->getBillRecapAnnualized($registrant);

        $composed= 
        'NO VA|Bill Key 2|Bill Key 3|Currency|NAMA|UNIT|KET|Bill Info 4|Bill Info 5|Bill Info 6|Bill Info 7|Bill Info 8|Bill Info 9|Bill Info 10|Bill Info 11|Bill Info 12|Bill Info 13|Bill Info 14|Bill Info 15|Bill Info 16|Bill Info 17|Bill Info 18|Bill Info 19|Bill Info 20|Bill Info 21|Bill Info 22|Bill Info 23|Bill Info 24|Bill Info 25|Periode Open|Periode Close|Tagihan 1|Tagihan 2|Tagihan 3|Tagihan 4|Tagihan 5|Tagihan 6|Tagihan 7|Tagihan 8|Tagihan 9|Tagihan 10|Tagihan 11|Tagihan 12|Tagihan 13|Tagihan 14|Tagihan 15|Tagihan 16|Tagihan 17|Tagihan 18|Tagihan 19|Tagihan 20|Tagihan 21|Tagihan 22|Tagihan 23|Tagihan 24|Tagihan 25|'.
        "\n".$va.'|||IDR|'.$name.'|'.$unit_name.' WARGA|SPP|||||||||||||||||||||||'.$open_date.'|'.$close_date.'|01\\TOTAL\\TOTAL\\'.$bill."|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|~";
         
        return $composed;
    }

    public function getBillRecapAnnualized($registrant){
        $unit_name = $registrant->unit->name;

        switch($unit_name){
            case 'KB/TK':
                    return '8650000';
                break;
            case 'SD':
                    return '7786500';
                break;
            case 'SMP':
                    return '10550000';
                break;
            case 'SMA':
                    return '12600000';
                break;
            case 'SMK':
                    if($registrant->unit->have_major){
                        $tier_name = $registrant->tier->tier_name;
                        switch($tier_name){
                            case 'Teknik Pemesinan':
                                    return '13150000';
                                break;
                            case 'Teknik Elektronika Industri':
                                    return '8150000';
                                break;
                            case 'Teknik Kendaraan Ringan':
                                    return '13150000';
                                break;
                            default:
                                    return '10';
                                break;
                        }
                    }else{
                        return '10';
                    }
                break;
            default:
                    return '10';
                break;
        }
    }
}
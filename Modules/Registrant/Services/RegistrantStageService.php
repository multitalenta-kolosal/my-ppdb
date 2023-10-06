<?php

namespace Modules\Registrant\Services;

use Modules\Registrant\Repositories\RegistrantStageRepository;
use Modules\Registrant\Entities\Registrant;
use Modules\Finance\Repositories\InstallmentRepository;
use Modules\Core\Services\UnitService;
use Modules\Core\Repositories\UnitRepository;
use Modules\Core\Repositories\PeriodRepository;
use App\Models\Notification;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegistrantStageService{

    protected $registrantStageRepository;

    protected $unitRepository;
    protected $unitService;

    protected $periodRepository;

    protected $installmentRepository;

    public function __construct(
        RegistrantStageRepository $registrantStageRepository,
        UnitRepository $unitRepository,
        UnitService  $unitService,
        PeriodRepository $periodRepository,
        InstallmentRepository $installmentRepository
    ) {

        $this->registrantStageRepository = $registrantStageRepository;

        $this->unitRepository = $unitRepository;

        $this->unitService = $unitService;

        $this->periodRepository = $periodRepository;

        $this->installmentRepository = $installmentRepository;

        $this->module_title = Str::plural(class_basename($this->registrantStageRepository->model()));

        $this->stages = config('stages.progress');
    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $registrantStage =$this->registrantStageRepository
                    ->all()
                    ->sortByDesc('created_at');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $registrantStage,
        );
    }

    public function store(Request $request, $registrant_data = null, $manualCreate = false){

        if(!$manualCreate){
            $data = $request->only('registrant_id');
        }else{
            $data = $request->all();
        }
       
        DB::beginTransaction();

        try {
            $regsitrantStageData = $this->registrantStageRepository->make($data);
            
            if($registrant_data){
                $regsitrantStageData->registrant_id = $registrant_data->registrant_id;
            }

            $registrantStage = $this->registrantStageRepository->create($regsitrantStageData->toArray());
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) $response = [
                'data'   => null,
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        DB::commit();

        if (Auth::check()) {
            Log::info(label_case($this->module_title.' '.__function__)." | Registrant Stages Created '".$registrantStage->registrant_id.'(ID:'.$registrantStage->id.") ");
        }else{
            Log::info(label_case($this->module_title.' '.__function__)." | '".$registrantStage->registrant_id.'(ID:'.$registrantStage->id.") ' by System)'");
        }

        $response = [
            'data'   => $registrantStage,
            'error' => false,
            'message' => '',
        ];
    
        return (object) $response;
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();
        try{
            $notified = $data["notified"] ?? false;

            $registrantStage = $this->registrantStageRepository->make($data);
            $registrant_stage_check = $this->registrantStageRepository->findBy('registrant_id',$registrantStage->registrant_id);

            if(array_key_exists("installment_id",$data)){
                $registrant = Registrant::where('registrant_id',$registrantStage->registrant_id)->first();
                [$registrant->scheme_tenor, $registrant->scheme_string, $registrant->scheme_amount, $registrant->scheme_amount_next]  = $this->unitService->proccessUnitFeeByTenor($registrant->type,$registrant->unit_id,$registrant->tier_id,$data["installment_id"]);
                $registrant->save();
            }

            foreach($this->stages as $stage){
                $validation = $stage['validation'];
                $validation_date = $validation.'_checked_date';
                if($registrantStage->$validation){
                    //if the validation is true then fill the date
                    if(!$registrant_stage_check->$validation_date){
                        $registrantStage->$validation_date = Carbon::now();
                    }
                }else{
                    $registrantStage->$validation_date = NULL;
                }
            }
                        
            if(array_key_exists("status_id",$data)){
                if($data['status_id'] > -1){
                    $registrantStage->status_id = $data['status_id'];
                }
            }else{
                $registrantStage->status_id = $this->getSetStatus($registrantStage);
            }

            $updated = $this->registrantStageRepository->update($registrantStage->toArray(),$registrant_stage_check->id);

            if($notified){
                $notification = Notification::where('id', '=', $notified)->where('notifiable_id', '=', auth()->user()->id)->first();

                if ($notification) {
                    if ($notification->read_at == '') {
                        $notification->read_at = Carbon::now();
                        $notification->save();
                    }
                }
            }
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) $response = [
                'data'   => null,
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrant_stage_check->name.'(ID:'.$registrant_stage_check->registrant_id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $response = [
            'data'   =>  $this->registrantStageRepository->find($registrant_stage_check->id),
            'error' => false,
            'message' => '',
        ];
    
        return (object) $response;

    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $registrantStages = $this->registrantStageRepository->findOrFail($id);
    
            $deleted = $this->registrantStageRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) $response = [
                'data'   => null,
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrantStages->name.', ID:'.$registrantStages->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        
        $response = [
            'data'   => $this->registrantStageRepository->find($id),
            'error' => false,
            'message' => '',
        ];
    
        return (object) $response;
    }

    public function getSetStatus($registrantStage){
        $progresses =  config('stages.progress');
        $status = 0;
        $skipped = [5];
        foreach($progresses as $progress){
            if(in_array($progress['status_id'], $skipped)){
                continue;
            }
            
            $validation = $progress['validation'];
            if($registrantStage->$validation){
                $status = $progress['status_id'];
            }
        }

        return $status;
    }

    public function chooseInstallments(Request $request){
        $data = $request->all();

        $period = $this->periodRepository->getActivePeriod();
        $this_month = Carbon::now()->floorMonth();
        $this_wave = NULL;
        
        if($this_month->lt(Carbon::parse($period->wave_1)->floorMonth())){
            
            $this_wave = "1";
            $expected_tenor = $this_month->diffInMonths(Carbon::parse($period->wave_1)->floorMonth());
        
        }else if($this_month->lt(Carbon::parse($period->wave_2)->floorMonth())){
        
            $this_wave = "2";
            $expected_tenor = $this_month->diffInMonths(Carbon::parse($period->wave_2)->floorMonth());
        
        }else if($this_month->lt(Carbon::parse($period->wave_3)->floorMonth())){
        
            $this_wave = "3";
            $expected_tenor = $this_month->diffInMonths(Carbon::parse($period->wave_3)->floorMonth());
        
        }else{
            $expected_tenor = NULL;
        }

        if($expected_tenor){

            $expected_installment = $this->installmentRepository->findBy('tenor',$expected_tenor);

            if($expected_installment){
                return (object) $response = [
                    'data'   => $expected_installment,
                    'error' => false,
                    'message' => "",
                ];
            }else{
                return (object) $response = [
                    'data'   => null,
                    'error' => true,
                    'message' => "Angsuran dengan jangka waktu ".$expected_tenor." bulan pada Gelombang".$this_wave." belum dibuat Silakan hubungi Kantor Yayasan",
                ];
            }
        }else{
            return (object) $response = [
                'data'   => null,
                'error' => true,
                'message' => "error when looking for expected tenor",
            ];
        }
        
    }
}
<?php

namespace Modules\Core\Services;

use Modules\Core\Entities\UnitPathFee;
use Modules\Core\Entities\UnitPathFeeManual;

use Modules\Core\Services\PathService;

use Modules\Core\Repositories\TierRepository;
use Modules\Core\Repositories\UnitRepository;
use Modules\Core\Repositories\PathRepository;

use Exception;
use Carbon\Carbon;
use Auth;

use App\Exceptions\GeneralException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Modules\Core\Events\Backend\TierCreated;

class TierService{

    protected $pathService;

    protected $tierRepository;
    protected $unitRepository;
    protected $pathRepository;

    public function __construct(
        PathService $pathService,

        PathRepository $pathRepository,
        TierRepository $tierRepository,
        UnitRepository $unitRepository
        )
        {
        $this->pathService = $pathService;
        
        $this->tierRepository = $tierRepository;
        $this->unitRepository = $unitRepository;
        $this->pathRepository = $pathRepository;

        $this->module_title = Str::plural(class_basename($this->tierRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $tier =$this->tierRepository->all();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tier,
        );
    }

    public function getList(){

        $tier =$this->tierRepository->all();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tier,
        );
    }


    public function create(){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $createOptions = $this->prepareOptions();

        return $createOptions;
    }

    public function store(Request $request){

        $data = $request->all();

        $field_value = 'path_';
        $paths = array();

        foreach($data as $key => $value){
            if (Str::contains($key, $field_value)) {
                $paths = Arr::add($paths,$value,Str::after($key, $field_value));
                unset($data[$key]);
            }
        }

        DB::beginTransaction();

        try {
            $tierObject = $this->tierRepository->make($data);
            $tierObject->paths = json_encode($paths);

            $tier = $this->tierRepository->create($tierObject->toArray());

            //Updating Paths
            $sync_path = $this->pathService->syncPath();
            $unitPathFee = $this->setUnitPathTierFee($data, $tier);

            if($sync_path->error){
                return (object) array(
                    'error'=> true,
                    'message'=> $sync_path->message,
                    'data'=> null,
                );            
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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$tier->name.'(ID:'.$tier->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tier,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->tierRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $tier = $this->tierRepository->findOrFail($id);

        $unitPathTierFees = $this->getUnitPathTierFee($id);
        $unitPathTierFeeManuals = $this->getUnitPathTierFeeManual($id);

        foreach($unitPathTierFees as $key => $value){
            $tier->setAttribute($key, $value);
        }

        foreach($unitPathTierFeeManuals as $key => $value){
            $tier->setAttribute($key, $value);
        }

        Log::info(label_case($this->module_title.' '.__function__)." | '".$tier->name.'(ID:'.$tier->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tier,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        $field_value = 'path_';
        $paths = array();

        foreach($data as $key => $value){
            if (Str::contains($key, $field_value)) {
                $paths = Arr::add($paths,$value,Str::after($key, $field_value));
                unset($data[$key]);
            }
        }

        DB::beginTransaction();

        try{
            $tier = $this->tierRepository->make($data);
            $tier->paths = json_encode($paths);

            if(!$tier->have_major){
                $tier->have_major = false;
            }

            $updated = $this->tierRepository->update($tier->toArray(),$id);

            $updated_tier = $this->tierRepository->findOrFail($id);
            
            //Updating Paths
            $sync_path = $this->pathService->syncPath();
            $unitPathFee = $this->setUnitPathTierFee($data, $updated_tier);

            if($sync_path->error){
                return (object) array(
                    'error'=> true,
                    'message'=> $sync_path->message,
                    'data'=> null,
                );            
            }

        }catch (Exception $e){
            DB::rollBack();
            report($e);
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$updated_tier->name.'(ID:'.$updated_tier->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $updated_tier,
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $tiers = $this->tierRepository->findOrFail($id);
    
            $deleted = $this->tierRepository->delete($id);
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$tiers->name.', ID:'.$tiers->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tiers,
        );
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->tierRepository->trashed(),
        );
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $tiers= $this->tierRepository->restore($id);
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

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$tiers->name.", ID:".$tiers->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tiers,
        );
    }
    
    public function prepareOptions(){
        
        $paths = $this->pathRepository->query()->orderBy('sort','asc')->pluck('name','id');

        if(!$paths){
            $paths = ['Silakan membuat Jalur Pendaftaran'];
        }
        
        $units = $this->unitRepository->query()->orderBy('order','asc')->pluck('name','id');

        if(!$units){
            $units = ['Silakan membuat Jalur Pendaftaran'];
        }

        $options = array(
            'paths' => $paths,
            'units' => $units,
        );

        return $options;
    }

    public function purge($id){
        DB::beginTransaction();

        try{
            $units = $this->tierRepository->findTrash($id);
    
            $deleted = $this->tierRepository->purge($id);
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$units->name.', ID:'.$units->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $units,
        );
    }

    public function purgeAll($all = false){
        DB::beginTransaction();

        try{
            if($all){
                $trashedDatas = $this->tierRepository->all();
            }else{
                $trashedDatas = $this->tierRepository->trashed();
            }

            foreach($trashedDatas as $trashedData){
                $purged = $this->tierRepository->purge($trashedData->id);
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


    public function setUnitPathTierFee($data, $tier){
        // make paths fee list. assign it to the unit path fee

        $paths =[];
        $field_value = 'path-fee-';
        foreach($data as $key => $value){
            if (Str::contains($key, $field_value)) {
                if(isset($value)){                    
                    $path_and_parameter_raw = Str::after($key, $field_value);
                    $path_and_parameter = explode("-",$path_and_parameter_raw);

                    $unitPathTierFee = UnitPathFee::updateOrCreate(
                        [
                            'unit_id' => $tier->unit_id,
                            'tier_id' => $tier->id,
                            'path_id' => $path_and_parameter[0]
                        ],
                        [
                            $path_and_parameter[1] => $value
                        ]
                        );
                }
            }
        }


        $field_value = 'path-feeManual-';
        foreach($data as $key => $value){
            if (Str::contains($key, $field_value)) {
                if(isset($value)){                    
                    $path_and_parameter_raw = Str::after($key, $field_value);
                    $path_and_parameter = explode("-",$path_and_parameter_raw);

                    $unitPathFee = UnitPathFeeManual::updateOrCreate(
                        [
                            'unit_id' => $tier->unit_id,
                            'tier_id' => $tier->id,
                            'path_id' => $path_and_parameter[0],
                            'tenor' => $path_and_parameter[1],
                            'payment_number' => $path_and_parameter[2]
                        ],
                        [
                            $path_and_parameter[3] => $value
                        ]
                        );
                }
            }
        }
    }


    public function getUnitPathTierFee($tier_id){
        // make paths fee list. assign it to the unit path fee
        $tier = $this->tierRepository->findOrFail($tier_id);
        $pathFees = UnitPathFee::where(['unit_id' => $tier->unit->id,'tier_id'=>$tier->id])->get();

        if($pathFees->count() < 0){
            return $pathFees; //empty paths
        }

        $field_value = 'path-fee-';

        $encoded_paths = [];
        foreach($pathFees as $pathFee){
           $temp_encoded_path = [
                $field_value.$pathFee->path_id.'-spp' => $pathFee->spp,
                $field_value.$pathFee->path_id.'-school_fee' => $pathFee->school_fee,
                $field_value.$pathFee->path_id.'-enabled' => $pathFee->enabled,
                $field_value.$pathFee->path_id.'-use_credit_scheme' => $pathFee->use_credit_scheme,
           ];

           $encoded_paths = $encoded_paths + $temp_encoded_path;
        }

        \Log::debug($encoded_paths);
        return $encoded_paths;

    }

    public function getUnitPathTierFeeManual($tier_id){
        $tier = $this->tierRepository->findOrFail($tier_id);
        $pathFeeManuals = UnitPathFeeManual::where(['unit_id' => $tier->unit->id,'tier_id'=>$tier_id])->get();

        if($pathFeeManuals->count() < 0){
            return $pathFeeManuals; //empty paths
        }

        $field_value = 'path-feeManual-';

        $encoded_manual_paths = [];
        foreach($pathFeeManuals as $pathFeeManual){
           $temp_encoded_path = [
                $field_value.$pathFeeManual->path_id.'-'.$pathFeeManual->tenor.'-'.$pathFeeManual->payment_number.'-spp' => $pathFeeManual->spp,
                $field_value.$pathFeeManual->path_id.'-'.$pathFeeManual->tenor.'-'.$pathFeeManual->payment_number.'-school_fee' => $pathFeeManual->school_fee,
           ];

           $encoded_manual_paths = $encoded_manual_paths + $temp_encoded_path;
        }

        \Log::debug($encoded_manual_paths);
        return $encoded_manual_paths;

    }
}
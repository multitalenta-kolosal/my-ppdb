<?php

namespace Modules\Core\Services;

use Modules\Core\Entities\UnitPathFee;

use Modules\Core\Services\PathService;

use Modules\Core\Repositories\UnitRepository;
use Modules\Core\Repositories\PathRepository;
use Modules\Core\Repositories\TierRepository;
use Modules\Finance\Repositories\InstallmentRepository;

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

use Modules\Core\Events\Backend\UnitCreated;

class UnitService{

    protected $pathService;

    protected $unitRepository;
    protected $pathRepository;
    protected $installmentRepository;

    public function __construct(
        PathService $pathService,

        PathRepository $pathRepository,
        UnitRepository $unitRepository,
        TierRepository $tierRepository,
        InstallmentRepository $installmentRepository
        )
        {
        $this->pathService = $pathService;
        
        $this->unitRepository = $unitRepository;
        $this->pathRepository = $pathRepository;
        $this->tierRepository = $tierRepository;
        $this->installmentRepository = $installmentRepository;

        $this->module_title = Str::plural(class_basename($this->unitRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $unit =$this->unitRepository->query()->orderBy('order','asc')->get();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $unit,
        );
    }

    public function getList(){

        $unit =$this->unitRepository->query()->orderBy('order','asc')->get();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $unit,
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

            $data['installment_ids'] = json_encode($data['installment_ids']);

            $unitObject = $this->unitRepository->make($data);
            $unitObject->paths = json_encode($paths);

            $unit = $this->unitRepository->create($unitObject->toArray());

            $unitPathFee = $this->setUnitPathFee($data, $unit->id);
            //Updating Paths
            $sync_path = $this->pathService->syncPath();

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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$unit->name.'(ID:'.$unit->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $unit,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->unitRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $unit = $this->unitRepository->findOrFail($id);

        $unit->installment_ids = json_decode($unit->installment_ids, true);

        $unitPathFees = $this->getUnitPathFee($id);

        foreach($unitPathFees as $key => $value){
            $unit->setAttribute($key, $value);
        }

        \Log::debug($unit);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$unit->name.'(ID:'.$unit->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $unit,
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
            $data['installment_ids'] = json_encode($data['installment_ids']);

            $unit = $this->unitRepository->make($data);
            $unit->paths = json_encode($paths);

            if(!$unit->have_major){
                $unit->have_major = false;
            }

            $updated = $this->unitRepository->update($unit->toArray(),$id);

            $updated_unit = $this->unitRepository->findOrFail($id);

            $unitPathFee = $this->setUnitPathFee($data, $id);
            //Updating Paths
            $sync_path = $this->pathService->syncPath();

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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$updated_unit->name.'(ID:'.$updated_unit->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $updated_unit,
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $units = $this->unitRepository->findOrFail($id);
    
            $deleted = $this->unitRepository->delete($id);
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

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->unitRepository->trashed(),
        );
    }
    
    public function setUnitPathFee($data, $id){
        // make paths fee list. assign it to the unit path fee

        $paths =[];
        $field_value = 'path-fee-';
        foreach($data as $key => $value){
            if (Str::contains($key, $field_value)) {
                // \Log::debug($key);
                // \Log::debug($value);

                // $paths = Arr::add($paths,Str::after($key, $field_value),$value);

                if(isset($value)){                    
                    $path_and_parameter_raw = Str::after($key, $field_value);
                    $path_and_parameter = explode("-",$path_and_parameter_raw);

                    $unitPathFee = UnitPathFee::updateOrCreate(
                        [
                            'unit_id' => $id,
                            'path_id' => $path_and_parameter[0]
                        ],
                        [
                            $path_and_parameter[1] => $value
                        ]
                        );
                }

                unset($data[$key]);
            }
        }

        \Log::debug($paths);

    }


    public function getUnitPathFee($id){
        // make paths fee list. assign it to the unit path fee
        $pathFees = UnitPathFee::where(['unit_id' => $id])->get();

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

    public function restore($id){

        DB::beginTransaction();

        try{
            $units= $this->unitRepository->restore($id);
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

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$units->name.", ID:".$units->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $units,
        );
    }
    
    public function prepareOptions(){
        
        $paths = $this->pathRepository->query()->orderBy('sort','asc')->pluck('name','id');

        if(!$paths){
            $paths = ['Silakan membuat Jalur Pendaftaran'];
        }

        $installments = $this->installmentRepository->query()->orderBy('id','asc')->pluck('name','id');

        if(!$installments){
            $installments = ['Silakan membuat Angsuran'];
        }
        $options = array(
            'paths' => $paths,
            'installments' => $installments
        );

        return $options;
    }


    public function decodePath($unit){
        
        $path = json_decode($unit->paths,true);

        if(!$path){
            $path = ['Path belum diisi'];
        }

        return $path;
    }

    //set option according to unit
    public function getUnitOpt($unit_id){
        $unit = $this->unitRepository->findOrFail($unit_id);
        $paths = [];
        $tiers = null;
        $raw_path = json_decode($unit->paths,true);

        if($raw_path){
            foreach($raw_path as $key => $value){
                $paths = Arr::add($paths, $key, $this->pathRepository->findOrFail($key)->name);
            }
        }

        if($unit->have_major){
            $tiers = $this->tierRepository->query()->where('unit_id',$unit_id)->pluck('tier_name','id');
        }
        \Log::debug(array(
            'error'     => false,            
            'message'   => '',
            'path'      => $paths,
            'tier'     => $tiers,
        ));
        return (object) array(
            'error'     => false,            
            'message'   => '',
            'path'      => $paths,
            'tier'     => $tiers,
        );
    }

    //set option according to unit
    public function getUnitFee($unit_id,$tier_id){
        $unit = $this->unitRepository->findOrFail($unit_id);
        $um = 0;
        $fees = $fees_amount = [];

        if($unit->have_major){

            if($tier_id == 0){
                return (object) array(
                    'error'     => false,            
                    'message'   => '',
                    'fees'      => [0 => "-- Silakan memilih kelas/jurusan terlebih dahulu --"],
                );
            }

            $tier = $this->tierRepository->findOrFail($tier_id);

            if(empty($tier->school_fee)){
                $um = $unit->school_fee;
            }else{
                $um = $tier->school_fee;
            }

        }else{
            if(empty($unit->school_fee)){
                $um = $unit->dp +$unit->dpp;
            }else{
                $um = $unit->school_fee;
            }
        }


        $payment_intervals = payment_interval();
        $payment_modifiers = payment_modifier();

        foreach($payment_intervals as $index => $payment_interval ){
            $modified_amount = ($um/$payment_interval) * $payment_modifiers[$index];

            if($modified_amount % 1000 != 0){
                $true_amount = ceil($modified_amount / 1000) * 1000;
            }else{
                $true_amount = $modified_amount;
            }
            
            $fees[$payment_interval] = $payment_interval." x Rp ".number_format($true_amount, 2, ',', '.');
            $fees_amount[$payment_interval] = $true_amount;
        }

        return (object) array(
            'error'            => false,            
            'message'          => '',
            'fees'             => $fees,
            'fees_amount'      => $fees_amount,
        );
    }

    public function proccessUnitFeeByTenor($unit_id,$tier_id,$tenor){
        $fees_object = $this->getUnitFee($unit_id,$tier_id);

        $fees = $fees_object->fees;
        $fees_amount = $fees_object->fees_amount;

        $scheme_string = $fees[$tenor];
        $scheme_amount = round($fees_amount[$tenor],0);

        return [$tenor, $scheme_string, $scheme_amount];
    }

    public function purge($id){
        DB::beginTransaction();

        try{
            $units = $this->unitRepository->findTrash($id);
    
            $deleted = $this->unitRepository->purge($id);
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
}
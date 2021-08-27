<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\PeriodRepository;
use Modules\Core\Repositories\UnitRepository;

use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Modules\Core\Events\Backend\PeriodCreated;

class PeriodService{

    protected $unitRepository;
    protected $periodRepository;

    public function __construct(
        /**
         * Services Parameter
         * 
         */
        
        /**
         * Repositories Parameter
         * 
         */
        UnitRepository $unitRepository,
        PeriodRepository $periodRepository
    ) { 
        /**
        * Services Declaration
        * 
        */

        /**
         * Repositories Declaration
         * 
         */
        $this->unitRepository = $unitRepository;
        $this->periodRepository = $periodRepository;

        $this->module_title = Str::plural(class_basename($this->periodRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $period =$this->periodRepository->all();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $period,
        );
    }

    public function create(){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $createOptions = $this->prepareOptions();

        return $createOptions;
    }

    public function store(Request $request){

        $data = $request->all();

        $quota = [];

        foreach($data as $key => $value){
            if (strpos($key, 'key') !== false) {
                $quota = Arr::add($quota,$key,$value);
                unset($data[$key]);
            }
        }

        DB::beginTransaction();

        try {
            $periodObject = $this->periodRepository->make($data);
            $periodObject->quota = json_encode($quota);

            $period = $this->periodRepository->create($periodObject->toArray());
        }catch (Exception $e){
            DB::rollBack();
            Log::info($e->getMessage());
            return (object) array(
                'error'=> true,            
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$period->name.'(ID:'.$period->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $period,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->periodRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $period = $this->periodRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$period->name.'(ID:'.$period->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $period,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();
        
        $quota = [];

        foreach($data as $key => $value){
            if (strpos($key, 'quota') !== false) {
                $quota = Arr::add($quota,$key,$value);
                unset($data[$key]);
            }
        }
        
        DB::beginTransaction();

        try{
            $period_check = $this->periodRepository->findOrFail($id);

            $periodObject = $this->periodRepository->make($data);

            $periodObject->quota = json_encode($quota);

            if(!$periodObject->active_state){    
                $periodObject->active_state = false;
            }

            $updated = $this->periodRepository->update($periodObject->toArray(),$id);

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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$period_check->name.'(ID:'.$period_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->periodRepository->find($id),
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $periods = $this->periodRepository->findOrFail($id);
    
            $deleted = $this->periodRepository->delete($id);
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$periods->name.', ID:'.$periods->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $periods,
        );
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->periodRepository->trashed(),
        );
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $periods= $this->periodRepository->restore($id);
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

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$periods->name.", ID:".$periods->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $periods,
        );
    }

    public function prepareOptions(){
        
        $unit = $this->unitRepository->query()->orderBy('order','asc')->pluck('name','id');

        if(!$unit){
            $unit = ['Silakan membuat unit'];
        }

        $options = array(
            'unit' => $unit,
        );

        return $options;
    }


    public function decodeQuota($period){
        
        $quota = json_decode($period->quota,true);


        if(!$quota){
            $quota = ['Quota belum diisi'];
        }

        return $quota;
    }

    public function purge($id){
        DB::beginTransaction();

        try{
            $units = $this->periodRepository->findTrash($id);
    
            $deleted = $this->periodRepository->purge($id);
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
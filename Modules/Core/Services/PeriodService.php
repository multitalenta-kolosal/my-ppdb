<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\PeriodRepository;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Modules\Core\Events\Backend\PeriodCreated;

class PeriodService{

    protected $periodRepository;

    public function __construct(PeriodRepository $periodRepository) {

        $this->periodRepository = $periodRepository;

        $this->module_title = Str::plural(class_basename($this->periodRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $period =$this->periodRepository->all();

        return $period;
    }

    public function getIndexList(Request $request){

        $listData = [];

        $term = trim($request->q);

        if (empty($term)) {
            return $listData;
        }

        $query_data = $this->periodRepository->findWhere(['name', 'LIKE', "%$term%"]);

        foreach ($query_data as $row) {
            $listData[] = [
                'id'   => $row->id,
                'text' => $row->name,
            ];
        }

        return $listData;
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
            $period = $this->periodRepository->create($data);
        }catch (Exception $e){
            DB::rollBack();
            Log::info($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$period->name.'(ID:'.$period->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $period;
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->periodRepository->findOrFail($id);
    }

    public function edit($id){

        $period = $this->periodRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$period->name.'(ID:'.$period->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $period;
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{
            $period_check = $this->periodRepository->findOrFail($id);

            $period = $this->periodRepository->make($data);

            if(!$period->active_state){
                $period->active_state = false;
                return null;
            }

            $updated = $this->periodRepository->update($period->toArray(),$id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$period_check->name.'(ID:'.$period_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->periodRepository->find($id);

    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $periods = $this->periodRepository->findOrFail($id);
    
            $deleted = $this->periodRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$periods->name.', ID:'.$periods->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $periods;
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->periodRepository->trashed();
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $periods= $this->periodRepository->restore($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$periods->name.", ID:".$periods->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $periods;
    }

}
<?php

namespace Modules\Registrant\Services;

use Modules\Registrant\Repositories\RegistrantStageRepository;
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

class RegistrantStageService{

    protected $registrantStageRepository;

    protected $unitRepository;

    protected $periodRepository;

    public function __construct(
        RegistrantStageRepository $registrantStageRepository,
        UnitRepository $unitRepository,
        PeriodRepository $periodRepository
    ) {

        $this->registrantStageRepository = $registrantStageRepository;

        $this->unitRepository = $unitRepository;

        $this->periodRepository = $periodRepository;

        $this->module_title = Str::plural(class_basename($this->registrantStageRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $registrantStage =$this->registrantStageRepository
                    ->all()
                    ->sortByDesc('created_at');

        return $registrantStage;
    }

    public function getIndexList(Request $request){

        $listData = [];

        $term = trim($request->q);

        if (empty($term)) {
            return $listData;
        }

        $query_data = $this->registrantStageRepository->findWhere(['name', 'LIKE', "%$term%"]);

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

    public function store(Request $request, $manualCreate = false){

        if(!$manualCreate){
            $data = $request->only('registrant_id');
        }else{
            $data = $request->all();
        }
       
        $registrantStage = $this->registrantStageRepository->make($data);

        DB::beginTransaction();

        try {
            $registrantStage = $this->registrantStageRepository->create($registrantStage->toArray());
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$registrantStage->name.'(ID:'.$registrantStage->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrantStage;
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->registrantStageRepository->findOrFail($id);
    }

    public function edit($id){

        $registrantStage = $this->registrantStageRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$registrantStage->name.'(ID:'.$registrantStage->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrantStage;
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{

            $registrant_stage_check = $this->registrantStageRepository->findOrFail($id);
     
            $registrantStage = $this->registrantStageRepository->make($data);

            $updated = $this->registrantStageRepository->update($registrantStage->toArray(),$id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrant_stage_check->name.'(ID:'.$registrant_stage_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->registrantStageRepository->find($id);

    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $registrantStages = $this->registrantStageRepository->findOrFail($id);
    
            $deleted = $this->registrantStageRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrantStages->name.', ID:'.$registrantStages->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrantStages;
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->registrantStageRepository->trashed();
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $registrantStages= $this->registrantStageRepository->restore($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$registrantStages->name.", ID:".$registrantStages->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrantStages;
    }

}
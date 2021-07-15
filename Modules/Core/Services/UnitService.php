<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\UnitRepository;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Modules\Core\Events\Backend\UnitCreated;

class UnitService{

    protected $unitRepository;

    public function __construct(UnitRepository $unitRepository) {

        $this->unitRepository = $unitRepository;

        $this->module_title = Str::plural(class_basename($this->unitRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $unit =$this->unitRepository->all();

        return $unit;
    }

    public function getIndexList(Request $request){

        $listData = [];

        $term = trim($request->q);

        if (empty($term)) {
            return $listData;
        }

        $query_data = $this->unitRepository->findWhere(['name', 'LIKE', "%$term%"]);

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
            $unit = $this->unitRepository->create($data);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$unit->name.'(ID:'.$unit->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $unit;
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->unitRepository->findOrFail($id);
    }

    public function edit($id){

        $unit = $this->unitRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$unit->name.'(ID:'.$unit->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $unit;
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{

            $unit_check = $this->unitRepository->findOrFail($id);
            
            $unit = $this->unitRepository->make($data);

            if(!$unit->has_major){
                $unit->has_major = false;
            }

            $updated = $this->unitRepository->update($unit->toArray(),$id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$unit_check->name.'(ID:'.$unit_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->unitRepository->find($id);

    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $units = $this->unitRepository->findOrFail($id);
    
            $deleted = $this->unitRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$units->name.', ID:'.$units->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $units;
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->unitRepository->trashed();
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $units= $this->unitRepository->restore($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$units->name.", ID:".$units->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $units;
    }

    public function generateId(){
        $year = Carbon::now()->format('y');

        $month = Carbon::now()->format('m');

        $response = [
            'id'   => $year.$month,
            'error' => false,
            'message' => '',
        ];
    
        return $response;
    }
}
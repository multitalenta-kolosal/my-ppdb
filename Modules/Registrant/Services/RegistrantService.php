<?php

namespace Modules\Registrant\Services;

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

class RegistrantService{

    protected $registrantRepository;

    protected $unitRepository;

    protected $periodRepository;

    public function __construct(
        RegistrantRepository $registrantRepository,
        UnitRepository $unitRepository,
        PeriodRepository $periodRepository
    ) {

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

    public function getIndexList(Request $request){

        $listData = [];

        $term = trim($request->q);

        if (empty($term)) {
            return $listData;
        }

        $query_data = $this->registrantRepository->findWhere(['name', 'LIKE', "%$term%"]);

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
            $registrant = $this->registrantRepository->create($data);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$registrant->name.'(ID:'.$registrant->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        event(new RegistrantCreated($registrant));

        return $registrant;
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

            $registrants = $this->registrantRepository->findOrFail($id);

            $updated = $this->registrantRepository->update($data,$id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrants->name.'(ID:'.$registrants->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

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
        }

        DB::commit();

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$registrants->name.", ID:".$registrants->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $registrants;
    }

    public function prepareOptions(){
        
        $unit = $this->unitRepository->pluck('name','id');

        if(!$unit){
            $unit = ['Silakan membuat unit'];
        }

        $type = [
            'Prestasi',
            'Reguler',
        ];

        $options = array(
            'unit' => $unit,
            'type' => $type,
        );

        return $options;
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
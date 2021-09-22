<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\PathRepository;
use Modules\Core\Repositories\UnitRepository;

use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PathService{

    protected $unitRepository;
    protected $pathRepository;

    public function __construct(
        PathRepository $pathRepository,
        UnitRepository $unitRepository
        ) {

        $this->pathRepository = $pathRepository;
        $this->unitRepository = $unitRepository;

        $this->module_title = Str::plural(class_basename($this->pathRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $path =$this->pathRepository->all();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $path,
        );
    }

    public function getList(){

        $path =$this->pathRepository->all();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $path,
        );
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
            $pathObject = $this->pathRepository->make($data);

            if(!$pathObject->additional_requirements){
                $pathObject->additional_requirements = "Tidak Ada\n";
            }
    
            $path = $this->pathRepository->create($pathObject->toArray());
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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$path->name.'(ID:'.$path->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $path,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->pathRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $path = $this->pathRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$path->name.'(ID:'.$path->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $path,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{
            $path_check = $this->pathRepository->findOrFail($id);
            
            $path = $this->pathRepository->make($data);

            if(!$path->additional_requirements){
                $path->additional_requirements = "Tidak Ada\n";
            }

            if(!$path->have_major){
                $path->have_major = false;
            }

            $updated = $this->pathRepository->update($path->toArray(),$id);

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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$path_check->name.'(ID:'.$path_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->pathRepository->find($id),
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $paths = $this->pathRepository->findOrFail($id);
    
            $deleted = $this->pathRepository->delete($id);
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$paths->name.', ID:'.$paths->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $paths,
        );
    }
    
    public function syncPath(){
        
        $units = $this->unitRepository->all();
        $paths = $this->pathRepository->all();
        
        DB::beginTransaction();

        try{
            foreach($paths as $path){
                $path_unit_used = [];

                foreach($units as $unit){
                    $unit_path = json_decode($unit->paths,true) ?? [];
                    if(array_key_exists($path->id,$unit_path)){
                        $path_unit_used = Arr::add($path_unit_used,$unit->id,$unit->name);
                    }
                }

                $path->units = json_encode($path_unit_used);
                $updated = $this->pathRepository->update($path->toArray(),$path->id);
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

        return (object) array(
            'error'=> false,
            'message'=> '',
            'data'=> null,
        );

    }
}
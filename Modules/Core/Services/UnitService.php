<?php

namespace Modules\Core\Services;

use Modules\Core\Services\PathService;

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

use Modules\Core\Events\Backend\UnitCreated;

class UnitService{

    protected $pathService;

    protected $unitRepository;
    protected $pathRepository;

    public function __construct(
        PathService $pathService,

        PathRepository $pathRepository,
        UnitRepository $unitRepository
        )
        {
        $this->pathService = $pathService;
        
        $this->unitRepository = $unitRepository;
        $this->pathRepository = $pathRepository;

        $this->module_title = Str::plural(class_basename($this->unitRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $unit =$this->unitRepository->all();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $unit,
        );
    }

    public function getList(){

        $unit =$this->unitRepository->all();

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
            $unitObject = $this->unitRepository->make($data);
            $unitObject->paths = json_encode($paths);

            $unit = $this->unitRepository->create($unitObject->toArray());

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
            Log::critical($e->getMessage());
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
            $unit = $this->unitRepository->make($data);
            $unit->paths = json_encode($paths);

            if(!$unit->has_major){
                $unit->has_major = false;
            }

            $updated = $this->unitRepository->update($unit->toArray(),$id);

            $updated_unit = $this->unitRepository->findOrFail($id);
            
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
            Log::critical($e->getMessage());
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
            Log::critical($e->getMessage());
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

    public function restore($id){

        DB::beginTransaction();

        try{
            $units= $this->unitRepository->restore($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
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
        
        $paths = $this->pathRepository->query()->orderBy('id','asc')->pluck('name','id');

        if(!$paths){
            $paths = ['Silakan membuat Jalur Pendaftaran'];
        }

        $options = array(
            'paths' => $paths,
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

    public function getPath($unit_id){
        $unit = $this->unitRepository->findOrFail($unit_id);
        $paths = [];
        $raw_path = json_decode($unit->paths,true);

        foreach($raw_path as $key => $value){
            $paths = Arr::add($paths, $key, $this->pathRepository->findOrFail($key)->name);
        }

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $paths,
        );
    }
}
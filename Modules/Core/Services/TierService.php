<?php

namespace Modules\Core\Services;

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

            if(!$tier->has_major){
                $tier->has_major = false;
            }

            $updated = $this->tierRepository->update($tier->toArray(),$id);

            $updated_tier = $this->tierRepository->findOrFail($id);
            
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
            Log::critical($e->getMessage());
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
            Log::critical($e->getMessage());
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
        
        $units = $this->unitRepository->query()->orderBy('order','asc')->pluck('name','id');

        if(!$units){
            $units = ['Silakan membuat Jalur Pendaftaran'];
        }

        $options = array(
            'units' => $units,
        );

        return $options;
    }
}
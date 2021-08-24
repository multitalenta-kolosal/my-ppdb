<?php

namespace Modules\Finance\Services;

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

class InstallmentService{

    protected $installmentRepository;
    public function __construct(
        InstallmentRepository $installmentRepository
        )
        {
        
        $this->installmentRepository = $installmentRepository;

        $this->module_title = Str::plural(class_basename($this->installmentRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $installment =$this->installmentRepository->all();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $installment,
        );
    }

    public function getList(){

        $installment =$this->installmentRepository->all();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $installment,
        );
    }


    public function create(){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> null,
        );
    }

    public function store(Request $request){

        $data = $request->all();

        DB::beginTransaction();

        try {
            $installmentObject = $this->installmentRepository->make($data);

            $installment = $this->installmentRepository->create($installmentObject->toArray());

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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$installment->name.'(ID:'.$installment->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $installment,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->installmentRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $installment = $this->installmentRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$installment->name.'(ID:'.$installment->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $installment,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{
            $installment = $this->installmentRepository->make($data);

            if(!$installment->have_major){
                $installment->have_major = false;
            }

            $updated = $this->installmentRepository->update($installment->toArray(),$id);

            $updated_installment = $this->installmentRepository->findOrFail($id);

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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$updated_installment->name.'(ID:'.$updated_installment->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $updated_installment,
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $installments = $this->installmentRepository->findOrFail($id);
    
            $deleted = $this->installmentRepository->delete($id);
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$installments->name.', ID:'.$installments->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $installments,
        );
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->installmentRepository->trashed(),
        );
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $installments= $this->installmentRepository->restore($id);
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

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$installments->name.", ID:".$installments->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $installments,
        );
    }

}
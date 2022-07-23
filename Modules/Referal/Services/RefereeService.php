<?php

namespace Modules\Referal\Services;

use Modules\Referal\Repositories\RefereeRepository;
use Modules\Core\Repositories\UnitRepository;


use Exception;
use Carbon\Carbon;
use Auth;
use PDF;

use App\Exceptions\GeneralException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RefereeService{

    protected $refereeRepository;
    protected $unitRepository;

    public function __construct(
        RefereeRepository $refereeRepository,
        UnitRepository $unitRepository
        )
        {
        
        $this->refereeRepository = $refereeRepository;
        $this->unitRepository = $unitRepository;

        $this->module_title = Str::plural(class_basename($this->refereeRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $referee =$this->refereeRepository->all();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referee,
        );
    }

    public function getList(){

        $referee =$this->refereeRepository->all();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referee,
        );
    }


    public function create(){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $createOptions = $this->prepareOptions();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $createOptions,
        );
    }

    public function store(Request $request){

        $data = $request->all();

        DB::beginTransaction();

        try {
            $refereeObject = $this->refereeRepository->make($data);

            $bank = preg_split('/-/',$data['bank_name']);

            $refereeObject->bank_code = $bank[0];
            $refereeObject->bank_name = $bank[1];
            $refereeObject->ref_code = $this->generateRefCode();

            $referee = $this->refereeRepository->create($refereeObject->toArray());

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

        \Log::debug($referee);

        if (Auth::check()) {
            Log::info(label_case($this->module_title.' '.__function__)." | '".$referee->name.'(ID:'.$referee->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');
        }else{
            Log::info(label_case($this->module_title.' '.__function__)." | '".$referee->name.'(ID:'.$referee->id.") ' by User: Guest)'");
        }

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referee,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->refereeRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $referee = $this->refereeRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$referee->name.'(ID:'.$referee->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referee,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{            
            $referee = $this->refereeRepository->make($data);

            $updated = $this->refereeRepository->update($referee->toArray(),$id);

            $updated_referee = $this->refereeRepository->findOrFail($id);

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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$updated_referee->name.'(ID:'.$updated_referee->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $updated_referee,
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $referees = $this->refereeRepository->findOrFail($id);
    
            $deleted = $this->refereeRepository->delete($id);
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$referees->name.', ID:'.$referees->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referees,
        );
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->refereeRepository->trashed(),
        );
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $referees= $this->refereeRepository->restore($id);
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

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$referees->name.", ID:".$referees->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referees,
        );
    }

    public function purge($id){
        DB::beginTransaction();

        try{
            $referees = $this->refereeRepository->findTrash($id);
    
            $deleted = $this->refereeRepository->purge($id);
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$referees->name.', ID:'.$referees->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referees,
        );
    }


    public function prepareOptions(){
        
        $banks= [];
        $bank_names= [];

        $raw_banks = config('banks');

        foreach($raw_banks as $raw_bank){
            $banks = Arr::add($banks, $raw_bank['code'].'-'.$raw_bank['name'], $raw_bank['code'].' - '.$raw_bank['name'] );
            $bank_names = Arr::add($bank_names, $raw_bank['name'], $raw_bank['name'] );
        }

        $options = array(
            'banks' => $banks,
            'bank_names' => $bank_names
        );

        return $options;
    }

    public function generateRefCode(){
        do {
            $randomString = Str::random(5);            
            $referalExists = $this->refereeRepository->findby('ref_code',$randomString);
        }
        while ($referalExists);

        return $randomString;
    }


    public function track(Request $request){
        $data = $request->all();
        
        DB::beginTransaction();

        try {
            $referee = $this->refereeRepository->findWhere([
                'email' => $data['email'],
                'phone' => $data['phone'],
            ])->first();

            if(!$referee){
                return (object) array(
                    'error'=> true,
                    'message'=> 'Data Referee tidak kami temukan, Silakan periksa ulang data yang anda masukkan',
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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$referee->name.'(ID:'.$referee->id.") IP: ".request()->getClientIp()."'' ");
            
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $referee,
        );
    }

    public function printReport($id){
        
        DB::beginTransaction();

        try {

            $referee = $this->refereeRepository->findOrFail($id);

            $pdf = PDF::loadView('referal::backend.referees.report', compact('referee'));
            
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

        Log::info("Generate Report for Referee");
            
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $pdf,
            'referee'=> $referee,
        );
    }
}
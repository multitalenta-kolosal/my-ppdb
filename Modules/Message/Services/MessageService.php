<?php

namespace Modules\Message\Services;

use Modules\Message\Repositories\MessageRepository;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MessageService{

    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository) {

        $this->messageRepository = $messageRepository;

        $this->module_title = Str::plural(class_basename($this->messageRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $message =$this->messageRepository->all();

        return $message;
    }

    public function getList(){

        $message =$this->messageRepository->all();

        return $message;
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
            $messageObject = $this->messageRepository->make($data);
    
            $message = $this->messageRepository->create($messageObject->toArray());
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$message->name.'(ID:'.$message->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $message;
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->messageRepository->findOrFail($id);
    }

    public function edit($id){

        $message = $this->messageRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$message->name.'(ID:'.$message->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $message;
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{
            $message_check = $this->messageRepository->findOrFail($id);
            
            $message = $this->messageRepository->make($data);

            if(!$message->has_major){
                $message->has_major = false;
            }

            $updated = $this->messageRepository->update($message->toArray(),$id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$message_check->name.'(ID:'.$message_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $this->messageRepository->find($id);

    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $messages = $this->messageRepository->findOrFail($id);
    
            $deleted = $this->messageRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$messages->name.', ID:'.$messages->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return $messages;
    }
}
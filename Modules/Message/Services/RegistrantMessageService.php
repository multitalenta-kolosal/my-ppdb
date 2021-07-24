<?php

namespace Modules\Message\Services;

use Modules\Message\Repositories\RegistrantMessageRepository;
use Modules\Core\Repositories\UnitRepository;
use Modules\Core\Repositories\PeriodRepository;
use App\Models\Notification;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegistrantMessageService{

    protected $registrantMessageRepository;

    protected $unitRepository;

    protected $periodRepository;

    public function __construct(
        RegistrantMessageRepository $registrantMessageRepository,
        UnitRepository $unitRepository,
        PeriodRepository $periodRepository
    ) {

        $this->registrantMessageRepository = $registrantMessageRepository;

        $this->unitRepository = $unitRepository;

        $this->periodRepository = $periodRepository;

        $this->module_title = Str::plural(class_basename($this->registrantMessageRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $registrantMessage =$this->registrantMessageRepository
                    ->all()
                    ->sortByDesc('created_at');

        return $registrantMessage;
    }

    public function store(Request $request, $registrant_data = null, $manualCreate = false){

        if(!$manualCreate){
            $data = $request->only('registrant_id');
        }else{
            $data = $request->all();
        }
       
        DB::beginTransaction();

        try {
            $regsitrantMessageData = $this->registrantMessageRepository->make($data);
            
            if($registrant_data){
                $regsitrantMessageData->registrant_id = $registrant_data->registrant_id;
            }

            $registrantMessage = $this->registrantMessageRepository->create($regsitrantMessageData->toArray());
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return $response = [
                'data'   => null,
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        DB::commit();

        if (Auth::check()) {
            Log::info(label_case($this->module_title.' '.__function__)." | Registrant Message Tracker Created '".$registrantMessage->registrant_id.'(ID:'.$registrantMessage->id.") ");
        }else{
            Log::info(label_case($this->module_title.' '.__function__)." | '".$registrantMessage->registrant_id.'(ID:'.$registrantMessage->id.") ' by System)'");
        }

        $response = [
            'data'   => $registrantMessage,
            'error' => false,
            'message' => '',
        ];
    
        return $response;
    }

    public function update(Request $request,$registrantMessageObject = null, $id){

        $data = $request->all();

        DB::beginTransaction();
        try{
            if($data){
                $registrantMessage = $this->registrantMessageRepository->make($data);
            }elseif($registrant){
                $registrantMessage = $this->registrantMessageRepository->make($registrantMessageObject);
            }
            $registrant_message_check = $this->registrantMessageRepository->findBy('registrant_id',$registrantMessage->registrant_id);
            $updated = $this->registrantMessageRepository->update($registrantMessage->toArray(),$registrant_message_check->id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return $response = [
                'data'   => null,
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrant_message_check->name.'(ID:'.$registrant_message_check->registrant_id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $response = [
            'data'   =>  $this->registrantMessageRepository->find($registrant_message_check->id),
            'error' => false,
            'message' => '',
        ];
    
        return $response;

    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $registrantMessages = $this->registrantMessageRepository->findOrFail($id);
    
            $deleted = $this->registrantMessageRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical($e->getMessage());
            return $response = [
                'data'   => null,
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$registrantMessages->name.', ID:'.$registrantMessages->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        
        $response = [
            'data'   => $this->registrantMessageRepository->find($id),
            'error' => false,
            'message' => '',
        ];
    
        return $response;
    }

}
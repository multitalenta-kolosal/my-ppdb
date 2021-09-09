<?php

namespace Modules\Message\Services;

use Modules\Message\Repositories\MessageRepository;
use Modules\Registrant\Repositories\RegistrantRepository;
use Modules\Message\Repositories\RegistrantMessageRepository;

use Modules\Message\Notifications\SendStageEmailToRegistrant;

use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MessageService{

    protected $registrantMessageRepository;
    protected $messageRepository;

    public function __construct(
         /**
         * Services Parameter
         * 
         */

        /**
         * Repositories Parameter
         * 
         */
        MessageRepository $messageRepository,
        RegistrantRepository $registrantRepository,
        RegistrantMessageRepository $registrantMessageRepository
    ) {
        /**
         * Services Declaration
         * 
         */

        /**
         * Repositories Declaration
         * 
         */
        $this->messageRepository = $messageRepository;
        $this->registrantRepository = $registrantRepository;
        $this->registrantMessageRepository = $registrantMessageRepository;

        $this->module_title = Str::plural(class_basename($this->messageRepository->model()));

    }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $message =$this->messageRepository->all();

        return $message;
    }

    public function getList(){

        $message =$this->messageRepository->all();
 
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $message,
        );
    }


    public function create(){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        $createOptions = $this->prepareOptions();

        return $createOptions;
    }

    public function store(Request $request){

        $data = $request->all();

        $replacement = [];

        foreach($data as $key => $value){
            if (strpos($key, 'rep-key') !== false) {
                $input_number = Str::after($key, 'rep-key');
                $replacement = Arr::add($replacement,$value,$data['rep-val'.$input_number]);
                unset($data[$key]);
                unset($data['rep-val'.$input_number]);
            }
        }


        DB::beginTransaction();

        try {
            $messageObject = $this->messageRepository->make($data);
    
            if($replacement){
                $messageObject->replacement = json_encode($replacement);
            }

            $message = $this->messageRepository->create($messageObject->toArray());
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$message->name.'(ID:'.$message->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $message,
        );
    }

    public function show($id){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->messageRepository->findOrFail($id),
        );
    }

    public function edit($id){

        $message = $this->messageRepository->findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$message->name.'(ID:'.$message->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $message,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        $replacement = [];

        foreach($data as $key => $value){
            if (strpos($key, 'rep-key') !== false) {
                $input_number = Str::after($key, 'rep-key');
                $replacement = Arr::add($replacement,$value,$data['rep-val'.$input_number]);
                unset($data[$key]);
                unset($data['rep-val'.$input_number]);
            }
        }
        
        DB::beginTransaction();

        try{
            $message_check = $this->messageRepository->findOrFail($id);
            
            $message = $this->messageRepository->make($data);

            if(!$message->have_major){
                $message->have_major = false;
            }

            if($replacement){
                $message->replacement = json_encode($replacement);
            }

            $updated = $this->messageRepository->update($message->toArray(),$id);

        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$message_check->name.'(ID:'.$message_check->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $this->messageRepository->find($id),
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $messages = $this->messageRepository->findOrFail($id);
    
            $deleted = $this->messageRepository->delete($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return null;
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$messages->name.', ID:'.$messages->id." ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $messages,
        );
    }

    public function prepareAndSend(Request $request){
        $data = $request->all();

        DB::beginTransaction();

        $message = '';

        try{
            $message_code = $data['message_code'];
            $registrant = $this->registrantRepository->findBy('registrant_id',$data['registrant_id']);
            $tracker_code = $data['tracker_code'];

            $replaces = [];
            switch($data['tracker_code']){
                case 'register':
                    $replaces = ['name' => $registrant->name, 'unit' => $registrant->unit->name];
                    break;
                case 'requirements':
                    $replaces = ['name' => $registrant->name, 'unit' => $registrant->unit->name];
                    break;
                case 'test':
                    $replaces = ['name' => $registrant->name, 'unit' => $registrant->unit->name];
                    break;
                case 'accepted':
                    $replaces = ['name' => $registrant->name, 'unit' => $registrant->unit->name];
                    break;
            }

            $response = $this->send($registrant, $message_code, $tracker_code);
    
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) $response = [
                'data'          => null,
                'registrant'    => $registrant,
                'error'         => true,
                'message'       => 'response message: '.$e->getMessage(),
            ];
        }

        DB::commit();


        Log::info(label_case($this->module_title.' '.__FUNCTION__).' '.$message_code." | '".$registrant->name.', ID:'.$registrant->registrant_id."'");

        return (object) $response;
    }

    public function send($registrant, $message_code, $tracker_code, $replaces = null){
        DB::beginTransaction();

        $message = '';

        try{
            $template = $this->messageRepository->findBy('code',$message_code);

            if($template)
            {
                $message = $template->message;

                if(!$replaces){
                    $replaces = $this->parseMessageReplaces($registrant, $template);
                }

                foreach($replaces as $key => $value){
                    $message =  Str::replace('$'.$key, $value, $message);
                }
            }

            $this->sendEmail($registrant, $message);
          
            $curl = curl_init();
            
            $apikey = $registrant->unit->api_key;
            $destination =  $this->getCleanNumber($registrant->phone);
            $message_text = $message;
            $message_custom_code = $message_code."_".$registrant->registrant_id."_".$tracker_code;

            $api_url = "http://panel.rapiwha.com/send_message.php";
            $api_url .= "?apikey=". urlencode ($apikey);
            $api_url .= "&number=". urlencode ($destination);
            $api_url .= "&text=". urlencode ($message_text);
            $api_url .= "&custom_data=". urlencode ($message_custom_code);

            curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $api_response = json_decode(curl_exec($curl));
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return (object) $response = [
                    'data'          => $api_response,
                    'registrant'    => $registrant,
                    'error'         => true,
                    'message'       => $err,
                ];
            }elseif($api_response){
                if (!$api_response->success){
                    return (object) $response = [
                        'data'          => $api_response,
                        'registrant'    => $registrant,
                        'error'         => true,
                        'message'       => $api_response->description,
                    ];          
                }      
            }else{
                return (object) $response = [
                    'data'          => null,
                    'registrant'    => $registrant,
                    'error'         => true,
                    'message'       => 'not get any response',
                ];     
            }
    
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) $response = [
                'data'          => null,
                'registrant'    => $registrant,
                'error'         => true,
                'message'       => 'response message: '.$e->getMessage(),
            ];
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' '.$message_code." ".', response:'.$api_response->description."' | '".$registrant->name.', ID:'.$registrant->registrant_id."'");

        return (object) $response = [
            'data'          => $api_response,
            'registrant'    => $registrant,
            'error'         => false,
            'message'       => '',
        ];
    }

    public function sendEmail($registrant, $message){
        if(setting('send_email')){
            if($registrant->email){
                Notification::route('mail', $registrant->email)
                    ->notify(new SendStageEmailToRegistrant($registrant, $message));
            }
        }
    }

    public function getCleanNumber($rawphone){
        return Str::replaceFirst('0','62',$rawphone);
    }

    public function messageEventCatch(Request $request){

        $data_request = $request->all();

        $tracker_suffix = "_pass_message_sent";

        DB::beginTransaction();

        $data = json_decode($data_request["data"]);

        try {
            $custom_data = explode('_', $data->custom_data);
            $message_code = $custom_data[0];
            $registrant = $this->registrantRepository->findBy('registrant_id',$custom_data[1]);
            $parameter = $custom_data[2];
            $parameter_value = 0;

            if($registrant){
                if ($data->event=="MESSAGEPROCESSED") {
                    $parameter_value = 1;
                }elseif ($data->event=="MESSAGEFAILED") {
                    $parameter_value = -1;
                }

                $updated = $this->registrantMessageRepository->update(
                    [
                        $parameter.$tracker_suffix => $parameter_value,
                    ]
                    ,
                    $registrant->registrant_message->id
                );

            }else{
                Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: registrant not found');
                return (object) $response = [
                    'data'   => null,
                    'error' => true,
                    'message' => 'registrant not found',
                ];
            }
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) $response = [
                'data'   => null,
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        DB::commit();

        Log::info(label_case($this->module_title.' Function: '.__function__)."' ". $parameter.$tracker_suffix." | Registrant ID:".$registrant->registrant_id."' | Destination:'".$registrant->phone.' (sender:'.$registrant->unit->name.") ' by: System'");

        return (object) $response = [
            'data'   => $data,
            'error' => false,
            'message' => '',
        ];
    }

    public function parseMessageReplaces($model, $template){
        $model_name = class_basename($model);
        $replacements = json_decode($template->replacement, false);

        $parsed = [];

        if($model_name == 'Registrant'){
            foreach($replacements as $key => $value){
                $connector = '->';
                if (Str::contains($value, $connector)) {
                    $relation = Str::before($value, $connector);
                    $relation_value = Str::after($value, $connector);

                    $parsed = Arr::add($parsed, $key, html_entity_decode($model->$relation->$relation_value));
                }else{
                    $parsed = Arr::add($parsed, $key, html_entity_decode($model->$value));
                }
            }
        }

        return $parsed;
    }
}
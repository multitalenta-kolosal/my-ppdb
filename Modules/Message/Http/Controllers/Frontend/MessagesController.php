<?php

namespace Modules\Message\Http\Controllers\Frontend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Modules\Message\Services\MessageService;
use Modules\Message\DataTables\MessagesDataTable;
use Modules\Message\Http\Requests\Frontend\WebhookRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class MessagesController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        // Page Title
        $this->module_title = 'Messages';

        // module name
        $this->module_name = 'messages';

        // directory path of the module
        $this->module_path = 'messages';

        // module icon
        $this->module_icon = 'fas fa-envelope';

        // module model name, path
        $this->module_model = "Modules\Message\Entities\Message";

        $this->messageService = $messageService;
    }

    /**
     * Catch rapiwha event and update database.
     *
     * @param int $id
     *
     * @return Response
     */
    public function messageWebhook(WebhookRequest $request){
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'webhook';

        $response = $this->messageService->messageEventCatch($request);

        if($response){
            return response()->json($response);
        }else{
            return response()->json($response);
        }
    }
}

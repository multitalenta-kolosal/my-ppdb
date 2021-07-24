<?php

namespace Modules\Message\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Modules\Message\Services\RegistrantMessageService;
use Modules\Message\DataTables\RegistrantMessagesDataTable;
use Modules\Message\Http\Requests\Backend\RegistrantMessagesRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class RegistrantMessagesController extends Controller
{
    use Authorizable;

    protected $registrantMessageService;

    public function __construct(RegistrantMessageService $registrantMessageService)
    {
        // Page Title
        $this->module_title = 'Registrantmessages';

        // mother module name
        $this->module_mother_name = 'registrants';

        // module name
        $this->module_name = 'registrantmessages';

        // directory path of the module
        $this->module_path = 'registrantmessages';

        // module icon
        $this->module_icon = 'fas fa-feather-alt';

        // module model name, path
        $this->module_model = "Modules\Message\Entities\RegistrantMessage";

        $this->registrantMessageService = $registrantMessageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RegistrantMessagesDataTable $dataTable)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::paginate();

        return $dataTable->render("message::backend.$module_path.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(RegistrantMessagesRequest $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $response = $this->registrantMessageService->store($request);

        if($response){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Added Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(RegistrantMessagesRequest $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = "Registrant Verification";

        $module_action = 'Update';

        $response = $this->registrantMessageService->update($request,$id);

        if($response){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Updated Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'destroy';

        $response = $this->registrantMessageService->destroy($id);

        if($response){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Deleted Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }
        
        return response()->json($response);
    }
}

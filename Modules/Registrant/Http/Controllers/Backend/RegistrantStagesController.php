<?php

namespace Modules\Registrant\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Modules\Registrant\Services\RegistrantStageService;
use Modules\Registrant\Http\Requests\Backend\RegistrantStagesRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class RegistrantStagesController extends Controller
{
    use Authorizable;

    protected $registrantStageService;

    public function __construct(RegistrantStageService $registrantStageService)
    {
        // Page Title
        $this->module_title = 'Registrantstages';

        // mother module name
        $this->module_mother_name = 'registrants';

        // module name
        $this->module_name = 'registrantstages';

        // directory path of the module
        $this->module_path = 'registrantstages';

        // module icon
        $this->module_icon = 'fas fa-feather-alt';

        // module model name, path
        $this->module_model = "Modules\Registrant\Entities\RegistrantStage";

        $this->registrantStageService = $registrantStageService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(RegistrantStagesRequest $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $response = $this->registrantStageService->store($request);

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
    public function update(RegistrantStagesRequest $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = "Registrant Verification";

        $module_action = 'Update';

        $response = $this->registrantStageService->update($request,$id);

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

        $response = $this->registrantStageService->destroy($id);
        
        return response()->json($response);
    }

    public function chooseInstallments(Request $request){
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'chooseInstallments';

        $response = $this->registrantStageService->chooseInstallments($request);

        return response()->json($response);
    }
}

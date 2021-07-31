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
use Modules\Registrant\Http\Requests\frontend\RegistrantStagesRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class RegistrantStagesController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $options = $this->registrantService->prepareOptions();

        $unit_options = $options['unit'];
        $type_options = $options['type'];

        return view(
            "registrant::frontend.$module_path.index",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','unit_options', 'type_options')
        );
    }
}

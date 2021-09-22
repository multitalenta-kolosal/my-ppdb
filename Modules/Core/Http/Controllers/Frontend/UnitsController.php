<?php

namespace Modules\Core\Http\Controllers\Frontend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Modules\Core\Services\UnitService;
use Spatie\Activitylog\Models\Activity;

class UnitsController extends Controller
{
    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        // Page Title
        $this->module_title = trans('menu.core.units');

        // module name
        $this->module_name = 'units';

        // directory path of the module
        $this->module_path = 'units';

        // module icon
        $this->module_icon = 'fas fa-map-signs';

        // module model name, path
        $this->module_model = "Modules\Unit\Entities\Unit";

        $this->unitService = $unitService;
    }

    /**
     * Get Path By Unit.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function getUnitOpt($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'get Path';

        $paths = $this->unitService->getUnitOpt($id);
        
        return response()->json($paths);
    }
}

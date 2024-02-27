<?php

namespace Modules\Referal\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Modules\Referal\Services\RefereeService;
use Modules\Referal\Http\Requests\Frontend\RefereesRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class RefereesController extends Controller
{
    protected $refereeService;

    public function __construct(RefereeService $refereeService)
    {
        // Page Title
        $this->module_title = trans('menu.referees');

        // module name
        $this->module_name = 'referees';

        // directory path of the module
        $this->module_path = 'referees';

        // module icon
        $this->module_icon = 'fas fa-user-friends';

        // module model name, path
        $this->module_model = "Modules\Referal\Entities\Referee";

        $this->refereeService = $refereeService;
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

        $options = $this->refereeService->prepareOptions();

        $banks = $options['banks'];

        return view(
            "referal::frontend.$module_path.index",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','banks')
        );
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $options = $this->refereeService->prepareOptions();

        $banks = $options['banks'];

        return view(
            "referal::frontend.$module_path.create",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','banks')
        );
    }
/**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function veriform()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $units = $this->refereeService->getUnits();

        return view(
            "referal::frontend.$module_path.veriform",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','units')
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function reftrack()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Reftracker';

        return view(
            "referal::frontend.$module_path.reftrack",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */

    public function refarea(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'refarea';

        $referee = $this->refereeService->track($request);

        if($referee->error){
            Flash::error("<i class='fas fa-times-circle'></i> ".$referee->message)->important();
            return redirect()->back();
        }

        return view(
            "referal::frontend.$module_path.refarea",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','referee')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(RefereesRequest $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $referees = $this->refereeService->store($request);

        $$module_name_singular = $referees;

        if(!$$module_name_singular->error){
            Flash::success('
                <h4>
                    <i class="fas fa-check"></i>
                        Anda Sudah terdaftar Sebagai Referee Yayasan Pendidikan Warga
                </h4>
                <p>
                        Untuk Selanjutnya Silakan Masuk ke Area Referee untuk Mengakses Link Referal Anda
                </p>'
                )->important();
        }else{
            Flash::error('
                <h4>
                    <i class="fas fa-times-circle"></i>
                        Pendaftaran Gagal!
                </h4>
                <h5>
                        Coba periksa kembali data anda dan silakan coba lagi
                </h5>'
            )->important();
        }

        return redirect("/ypwreferal");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(RefereesRequest $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $referees = $this->refereeService->update($request,$id);

        $$module_name_singular = $referees->data;

        if($referees->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Updated Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return redirect("admin/$module_name");
    }
}

<?php

namespace Modules\Registrant\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Flash;
use GeneaLabs\LaravelMultiStepProgressbar\ProgressbarItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Modules\Registrant\Services\RegistrantService;
use Modules\Registrant\Http\Requests\Frontend\RegistrantsRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class RegistrantsController extends Controller
{
    protected $registrantService;

    public function __construct(RegistrantService $registrantService)
    {
        // Page Title
        $this->module_title = trans('menu.registrants');

        // module name
        $this->module_name = 'registrants';

        // directory path of the module
        $this->module_path = 'registrants';

        // module icon
        $this->module_icon = 'fas fa-feather-alt';

        // module model name, path
        $this->module_model = "Modules\Registrant\Entities\Registrant";

        $this->registrantService = $registrantService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index($ref=null)
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

        $units = $this->registrantService->getUnits();

        return view(
            "registrant::frontend.$module_path.veriform",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','units')
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function track()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Tracker';

        return view(
            "registrant::frontend.$module_path.track",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */

    public function progress(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $registrant = $this->registrantService->track($request);
        
        if($registrant->error){
            return response()->json($registrant);
        }

        return view(
            "registrant::frontend.$module_path.progress",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','registrant')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(RegistrantsRequest $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $registrants = $this->registrantService->store($request);

        $$module_name_singular = $registrants;

        if(!$$module_name_singular->error){
            Flash::success('
                <h4>
                    <i class="fas fa-check"></i> 
                        Terima kasih sudah mendaftar!
                </h4>
                <h5>
                    Silakan tunggu pesan di Email atau Whatsapp untuk masuk ke HP mu
                </h5>
                    Jika setelah 30 menit belum mendapat pesan bisa menghubungi (WA) '
                    .$registrants->data->unit->contact_number.
                    ' Untuk info lebih lanjut.'
                )->important();
        }else{
            Flash::error('
                <h4>
                    <i class="fas fa-times-circle"></i> 
                        Pendaftaran Gagal!
                </h4>
                <h5>
                    Silakan coba lagi
                </h5>
                    Jika mengalami masalah silakan menghubungi (WA) 
                    '.$registrants->data->unit->contact_number.' 
                    Untuk info lebih lanjut.'
            )->important();
        }

        return redirect("/");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(RegistrantsRequest $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $registrants = $this->registrantService->update($request,$id);

        $$module_name_singular = $registrants->data;

        if($registrants->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Updated Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return redirect("admin/$module_name");
    }
}

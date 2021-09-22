<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Artisan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Log;
use Storage;

use Modules\Registrant\Services\RegistrantService;

class PurgeController extends Controller
{
    use Authorizable;

    protected $registrantService;

    public function __construct(
        RegistrantService $registrantService
    )
    {
        // Page Title
        $this->module_title = trans('menu.purges');

        // module name
        $this->module_name = 'purges';

        // directory path of the module
        $this->module_path = 'purges';

        // module icon
        $this->module_icon = 'fas fa-archive';

        $this->models = [
            'Registrant' => 'Registrant' ,
        ];

        $this->registrantService = $registrantService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $this->models;
        
        return view(
            "backend.$module_path.purges",
            compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular')
        );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function purgeAll($name)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Purge All';

        $$module_name = $this->models;

        switch($name){
            case 'Registrant':
                $purges = $this->registrantService->purgeAll(true);
                break;
        }

        
        return  redirect("admin/");
    }

}

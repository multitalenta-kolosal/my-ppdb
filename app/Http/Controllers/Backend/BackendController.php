<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Auth;

use Modules\Registrant\Repositories\RegistrantRepository;
use Modules\Core\Repositories\PeriodRepository;

class BackendController extends Controller
{

    protected $registrantRepository;
    protected $periodRepository;

    public function __construct(
        PeriodRepository $periodRepository,
        RegistrantRepository $registrantRepository
    )
    {
        $this->periodRepository = $periodRepository;
        $this->registrantRepository = $registrantRepository;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $color_arr = [];

        if(Auth::user()){
            if(!Auth::user()->isSuperAdmin() && !Auth::user()->hasAllUnitAccess()){
                // $color_array = [Auth::user()->unit->name => $color_arr[Auth::user()->unit->name]];
                $color_array = Arr::add($color_arr,'single_unit','#225987');
                $color = json_encode(array_values($color_array));
            }else{
                $color_arr = Arr::add($color_arr,'KB/TK','#FFA900');
                $color_arr = Arr::add($color_arr,'SD','#00B74A');
                $color_arr = Arr::add($color_arr,'SMP','#F93154');
                $color_arr = Arr::add($color_arr,'SMA','#1266F1');
                $color_arr = Arr::add($color_arr,'SMK','#B23CFD');
                $color_array = $color_arr;
                $color = json_encode(array_values($color_array));
            }
        }else{
            $color_array = Arr::add($color_arr,'single_unit','#225987');
            $color = json_encode(array_values($color_array));
        }

        $batch_period = $this->periodRepository->getActivePeriod();
        $unit_counts = $this->registrantRepository->getCount();

        return view('backend.index',compact('color','unit_counts','color_array','batch_period'));
    }
}

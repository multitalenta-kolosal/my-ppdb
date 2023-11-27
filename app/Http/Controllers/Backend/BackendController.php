<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Auth;

use Illuminate\Http\Request;
use Modules\Registrant\Entities\Registrant;
use Modules\Registrant\Repositories\RegistrantRepository;
use Modules\Core\Repositories\PeriodRepository;
use Modules\Registrant\Charts\RegistrantInsight;
use Modules\Registrant\Charts\RegistrantStageInsight;

class BackendController extends Controller
{

    protected $registrantRepository;
    protected $periodRepository;

    public function __construct(
        PeriodRepository $periodRepository,
        RegistrantRepository $registrantRepository,
        RegistrantInsight $registrantInsight,
        RegistrantStageInsight $registrantStageInsight
    )
    {
        $this->periodRepository = $periodRepository;
        $this->registrantRepository = $registrantRepository;
        $this->registrantInsight = $registrantInsight;
        $this->registrantStageInsight = $registrantStageInsight;
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

        $insights = $this->registrantInsight->build();
        $stageInsights = $this->registrantInsight->build();

        $batch_period = $this->periodRepository->getSessionPeriod();
        $unit_counts = $this->registrantRepository->getCount();

        return view('backend.index',compact('color','unit_counts','color_array','batch_period','insights'));
    }

     /**
     * Show the analytics dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function analytics_index()
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

        $insights = $this->registrantInsight->build();
        $stageInsights = $this->registrantStageInsight->build();

        $batch_period = $this->periodRepository->getSessionPeriod();
        $unit_counts = $this->registrantRepository->getCount();

        return view('backend.analytics-index',compact('color','unit_counts','color_array','batch_period','insights','stageInsights'));
    }

    public function typeStats(Request $request){

        // Get parameters from the request
        $unitId = $request->input('unit_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $statsRegistrant = Registrant::where('period_id',my_period())->select('paths.name as path_name', \DB::raw('count(*) as count'))
            ->join('paths', 'registrants.type', '=', 'paths.id')
            ->when($unitId, function ($query) use ($unitId) {
                $query->where('registrants.unit_id', $unitId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $startDateFormatted = Carbon::parse($startDate)->startOfDay();
                $endDateFormatted = Carbon::parse($endDate)->endOfDay();
        
                $query->whereBetween('registrants.created_at', [$startDateFormatted, $endDateFormatted]);
            })
            ->groupBy('path_name')
            ->get();
        
            
        $statsRegistrantHereg = Registrant::where('period_id',my_period())->select('paths.name as path_name', \DB::raw('count(*) as count'))
        ->join('paths', 'registrants.type', '=', 'paths.id')
        ->join('registrant_stages', 'registrants.progress_id', '=', 'registrant_stages.id')
        ->where('registrant_stages.accepted_pass',1)
        ->when($unitId, function ($query) use ($unitId) {
            $query->where('registrants.unit_id', $unitId);
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('registrant_stages.accepted_pass_checked_date', [$startDate, $endDate]);
        })
        ->groupBy('path_name')
        ->get();


        return view('backend.type-stats', compact('statsRegistrant','statsRegistrantHereg'))->render();

    }
}

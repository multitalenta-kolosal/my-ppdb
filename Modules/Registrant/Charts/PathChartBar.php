<?php

declare(strict_types = 1);

namespace Modules\Registrant\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Auth;
use Illuminate\Support\Arr;

use Modules\Registrant\Entities\Registrant;
use Modules\Core\Entities\Path;

class PathChartBar extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
 
    public function handler(Request $request): Chartisan
    {
        $default_path = [];
        $counted_path =[];
        $paths = Path::select('id','name')->get();

        foreach($paths as $path){
           $default_path =Arr::add($default_path, $path->id,0);
        }

        $chartisan = Chartisan::build();
        if(!Auth::user()->isSuperAdmin() && !Auth::user()->hasAllUnitAccess()){
            $path_count = DB::table('registrants')
                            ->select('type', DB::raw('count(*) as total'))
                            ->where('period_id',my_period())
                            ->where('unit_id',Auth::user()->unit_id)
                            ->where('deleted_at',NULL)
                            ->groupBy('type')
                            ->get();
        }else{
            $path_count = DB::table('registrants')
                            ->select('type', DB::raw('count(*) as total'))
                            ->where('period_id',my_period())
                            ->where('deleted_at',NULL)
                            ->groupBy('type')
                            ->get();
        }

        $merged_array = array_replace_recursive($default_path,$path_count->pluck('total','type')->all());
        
        $chartisan = $chartisan->labels($paths->pluck('name')->all())
                    ->dataset('Pendaftar',array_values($merged_array));

        return $chartisan;
    }
}
<?php

declare(strict_types = 1);

namespace Modules\Registrant\Charts;

use Nabcellent\Chartisan\BaseChart;
use Nabcellent\Chartisan\Chartisan\Chartisan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Auth;
use Illuminate\Support\Arr;

use Modules\Registrant\Services\RegistrantService;

use Modules\Registrant\Entities\Registrant;
use Modules\Core\Entities\Unit;

class RegistrantChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
 
    public function handler(Request $request): Chartisan
    {
        $default_date = [];
        $units = Unit::orderBy('order','ASC')->pluck('name','id')->all();
        $registrant_collections =[];

        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        
        if($request->periods){
            $periods = $request->periods;
            if(is_numeric($periods)){
                $default_date_raw = CarbonPeriod::create(Carbon::now()->subDays($periods), Carbon::now())->toArray();
                
                foreach($default_date_raw as $value){
                    array_push($default_date,$value->format('d M'));
                }

                $count_keys = $default_date;
                $default_count = array_fill_keys($count_keys, 0);

                if(!Auth::user()->isSuperAdmin() && !Auth::user()->hasAllUnitAccess()){
                    switch($driver){
                        case 'mysql':
                            $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subDays($periods))
                                        ->where('unit_id','=',Auth::user()->unit_id)
                                        ->ThisPeriod(my_period())
                                        ->groupBy('date')
                                        ->orderBy('date', 'ASC')
                                        ->get(array(
                                            DB::raw('DATE_FORMAT(created_at, "%d %b") as date'),
                                            DB::raw('COUNT(*) as "views"')
                                        )
                                    );
                        break;
                        case 'pgsql':
                            $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subDays($periods))
                                            ->where('unit_id','=',Auth::user()->unit_id)
                                            ->ThisPeriod(my_period())
                                            ->groupBy('date')
                                            ->orderBy('date', 'ASC')
                                            ->get(array(
                                                DB::raw('TO_CHAR(created_at, '."'DD Mon'".') as date'),
                                                DB::raw('COUNT(*) as "views"')
                                            )
                                        );
                        break;
                        default:
                            throw new \Exception('Driver not supported.');
                        break;
                    }
                }else{
                    foreach($units as $key => $unit){
                        switch($driver){
                            case 'mysql':
                                $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subDays($periods))
                                                ->where('unit_id','=', $key)
                                                ->ThisPeriod(my_period())
                                                ->groupBy('date')
                                                ->orderBy('date', 'ASC')
                                                ->get(array(
                                                    DB::raw('DATE_FORMAT(created_at, "%d %b") as date'),
                                                    DB::raw('COUNT(*) as "views"')
                                                )
                                            );
                            break;
                            case 'pgsql':
                                $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subDays($periods))
                                                ->where('unit_id','=', $key)
                                                ->ThisPeriod(my_period())
                                                ->groupBy('date')
                                                ->orderBy('date', 'ASC')
                                                ->get(array(
                                                    DB::raw('TO_CHAR(created_at, '."'DD Mon'".') as date'),
                                                    DB::raw('COUNT(*) as "views"')
                                                )
                                            );
                            break;
                            default:
                                throw new \Exception('Driver not supported.');
                            break;
                        }
                        $registrant_collections = Arr::add($registrant_collections, $unit, $registrant);
                    }
                }
            }else{
                if($periods == 'monthly'){
                    $periods = 6;
                }else if($periods == 'year'){
                    $periods = 11;
                }

                $default_date_raw = CarbonPeriod::create(Carbon::now()->subMonth($periods), Carbon::now())->toArray();
                
                foreach($default_date_raw as $value){
                    array_push($default_date,$value->format('M'));
                }

                $count_keys = $default_date;
                $default_count = array_fill_keys($count_keys, 0);

                if(!Auth::user()->isSuperAdmin() && !Auth::user()->hasAllUnitAccess()){

                    switch($driver){
                        case 'mysql':
                            $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subMonth($periods)->startOfMonth())
                                        ->where('unit_id','=',Auth::user()->unit_id)
                                        ->ThisPeriod(my_period())
                                        ->where('deleted_at',NULL)
                                        ->groupBy('date')
                                        ->orderBy('date', 'ASC')
                                        ->get(array(
                                            DB::raw('DATE_FORMAT(created_at, "%b") as date'),
                                            DB::raw('COUNT(*) as "views"')
                                        )
                                    );
                        break;
                        case 'pgsql':
                            $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subMonth($periods)->startOfMonth())
                                            ->where('unit_id','=',Auth::user()->unit_id)
                                            ->ThisPeriod(my_period())
                                            ->where('deleted_at',NULL)
                                            ->groupBy('date')
                                            ->orderBy('date', 'ASC')
                                            ->get(array(
                                                DB::raw('TO_CHAR(created_at, '."'Mon'".') as date'),
                                                DB::raw('COUNT(*) as "views"')
                                            )
                                        );
                        break;
                        default:
                            throw new \Exception('Driver not supported.');
                        break;
                    }
                }else{
                    foreach($units as $key => $unit){
                        
                        switch($driver){
                            case 'mysql':
                                $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subMonth($periods)->startOfMonth())
                                                ->where('unit_id','=', $key)
                                                ->ThisPeriod(my_period())
                                                ->where('deleted_at',NULL)
                                                ->groupBy('date')
                                                ->orderBy('date', 'ASC')
                                                ->get(array(
                                                    DB::raw('DATE_FORMAT(created_at, "%b") as date'),
                                                    DB::raw('COUNT(*) as "views"')
                                                )
                                            );
                            break;
                            case 'pgsql':
                                $registrant =  Registrant::where('created_at', '>=', Carbon::now()->subMonth($periods)->startOfMonth())
                                                ->where('unit_id','=', $key)
                                                ->ThisPeriod(my_period())
                                                ->where('deleted_at',NULL)
                                                ->groupBy('date')
                                                ->orderBy('date', 'ASC')
                                                ->get(array(
                                                    DB::raw('TO_CHAR(created_at, '."'Mon'".') as date'),
                                                    DB::raw('COUNT(*) as "views"')
                                                )
                                            );
                            break;
                            default:
                                throw new \Exception('Driver not supported.');
                            break;
                        }
                        $registrant_collections = Arr::add($registrant_collections, $unit, $registrant);
                    }
                }
            }

            if(!Auth::user()->isSuperAdmin() && !Auth::user()->hasAllUnitAccess()){
                $merged_count = array_replace_recursive($default_count, $registrant->pluck('views','date')->all());
                [$dates, $count] = Arr::divide($merged_count);

                return Chartisan::build()
                    ->labels($dates)
                    ->dataset(Auth::user()->unit->name,$count);
            }else{
                $chartisan = Chartisan::build();
                
                foreach($units as $key => $unit){
                    $merged_count = array_replace_recursive($default_count, $registrant_collections[$unit]->pluck('views','date')->all());

                    [$dates, $count] = Arr::divide($merged_count);
                    $chartisan = $chartisan->labels($dates)
                                ->dataset($unit,$count);
                }

                return $chartisan;
            }
        }else{
            return Chartisan::build();
        }
    }
}
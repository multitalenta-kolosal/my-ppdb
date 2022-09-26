<?php

namespace Modules\Registrant\Repositories;

use App\Repositories\BaseRepository;
use Modules\Registrant\Repositories\Contracts\RegistrantRepositoryInterface;
use Modules\Registrant\Entities\Registrant;
use DB;

/** @property Registrant $model */
class RegistrantRepository extends BaseRepository implements RegistrantRepositoryInterface
{
    public function model()
    {
        return Registrant::class;
    }

    public function getBiggestUnitIncrement($unit_id)
    {
        return Registrant::where('unit_id', $unit_id)->withTrashed()->ThisPeriod()->max('unit_increment');
    }

    public function getRegistrantsByUnitQuery($query, $unit_id){
        return $query->where('unit_id', $unit_id)->ThisPeriod(session('period'));
    }

    public function getCount($unit_id = null){
        if($unit_id){
            return Registrant::join('units', 'units.id', '=', 'registrants.unit_id')
                        ->join('registrant_stages', 'registrant_stages.registrant_id', '=', 'registrants.registrant_id')
                        ->where('unit_id','=', $unit_id)
                        ->ThisPeriod(session('period'))
                        ->groupBy('unit','units.order')
                        ->orderBy('units.order')
                        ->get(array(
                            DB::raw('units.name as unit'),
                            DB::raw('COUNT(*) as "amount"'),
                            DB::raw('COUNT(CASE accepted_pass WHEN true THEN 1 ELSE NULL END) as "accepted_amount"')
                        )
                    );  
        }else{
            return Registrant::join('units', 'units.id', '=', 'registrants.unit_id')
                        ->ThisPeriod(session('period'))
                        ->join('registrant_stages', 'registrant_stages.registrant_id', '=', 'registrants.registrant_id')
                        ->groupBy('unit','units.order')
                        ->orderBy('units.order')
                        ->get(array(
                            DB::raw('units.name as unit'),
                            DB::raw('COUNT(*) as "amount"'),
                            DB::raw('COUNT(CASE accepted_pass WHEN true THEN 1 ELSE NULL END) as "accepted_amount"')
                        )
                    );        
        }
    }
}

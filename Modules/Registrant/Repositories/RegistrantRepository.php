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
        return Registrant::where('unit_id', $unit_id)->withTrashed()->max('unit_increment');
    }

    public function getRegistrantsByUnitQuery($query, $unit_id){
        return $query->where('unit_id', $unit_id)->withTrashed();
    }

    public function getCount($unit_id = null){
        if($unit_id){
            return Registrant::join('units', 'units.id', '=', 'registrants.unit_id')
                        ->where('unit_id','=', $unit_id)
                        ->groupBy('unit','units.order')
                        ->orderBy('units.order')
                        ->get(array(
                            DB::raw('units.name as unit'),
                            DB::raw('COUNT(*) as "amount"')
                        )
                    );  
        }else{
            return Registrant::join('units', 'units.id', '=', 'registrants.unit_id')
                        ->groupBy('unit','units.order')
                        ->orderBy('units.order')
                        ->get(array(
                            DB::raw('units.name as unit'),
                            DB::raw('COUNT(*) as "amount"')
                        )
                    );        
        }
    }
}

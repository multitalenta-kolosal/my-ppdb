<?php

namespace Modules\Core\Repositories;

use App\Repositories\BaseRepository;
use Modules\Core\Repositories\Contracts\UnitRepositoryInterface;
use Modules\Core\Entities\Unit;

/** @property Unit $model */
class UnitRepository extends BaseRepository implements UnitRepositoryInterface
{
    public function model()
    {
        return Unit::class;
    }

    public function getUnitsByUnitQuery($query, $unit_id){
        return $query->where('id', $unit_id)->withTrashed();
    }
}

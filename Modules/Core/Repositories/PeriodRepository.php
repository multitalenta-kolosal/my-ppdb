<?php

namespace Modules\Core\Repositories;

use App\Repositories\BaseRepository;
use Modules\Core\Repositories\Contracts\PeriodRepositoryInterface;
use Modules\Core\Entities\Period;

/** @property Period $model */
class PeriodRepository extends BaseRepository implements PeriodRepositoryInterface
{
    public function model()
    {
        return Period::class;
    }

    public function getActivePeriod()
    {
        $period = Period::where('active_state',true)->first();
        if($period)
            return $period;
        else
            return null;
    }

    public function findActivePeriodId()
    {
        $period = Period::where('active_state',true)->first();
        if($period)
            return $period->id;
        else
            return null;
    }
}

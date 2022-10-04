<?php

namespace Modules\Core\Repositories;

use App\Repositories\BaseRepository;
use Modules\Core\Repositories\Contracts\PeriodRepositoryInterface;
use Modules\Core\Entities\Period;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function getSessionPeriod()
    {
        $period = Period::findOrFail(session('period'));
        if($period)
            return $period;
        else
            return null;
    }

    public function activatePeriod($id)
    {
        $period = Period::findOrFail($id);

        $period->active_state = true;

        $status = $period->save();

        if($status){
            return true;
        }else{
            return false;
        }

    }

    public function deactivatePeriod($id)
    {
        $period = Period::findOrFail($id);

        $period->active_state = false;

        $status = $period->save();

        if($status){
            return true;
        }else{
            return false;
        }

    }

    public function findActivePeriodId()
    {
        return Period::findActivePeriodId();
    }
}

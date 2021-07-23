<?php

namespace Modules\Registrant\Repositories;

use App\Repositories\BaseRepository;
use Modules\Registrant\Repositories\Contracts\RegistrantStageRepositoryInterface;
use Modules\Registrant\Entities\RegistrantStage;

/** @property RegistrantStage $model */
class RegistrantStageRepository extends BaseRepository implements RegistrantStageRepositoryInterface
{
    public function model()
    {
        return RegistrantStage::class;
    }

    public function getBiggestUnitIncrement($unit_id)
    {
        return RegistrantStage::where('unit_id', $unit_id)->withTrashed()->max('unit_increment');
    }
}

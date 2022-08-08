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

}

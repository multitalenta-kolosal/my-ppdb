<?php

namespace Modules\Referal\Repositories;

use App\Repositories\BaseRepository;
use Modules\Referal\Repositories\Contracts\RefereeRepositoryInterface;
use Modules\Referal\Entities\Referee;

/** @property Referee $model */
class RefereeRepository extends BaseRepository implements RefereeRepositoryInterface
{
    public function model()
    {
        return Referee::class;
    }
}

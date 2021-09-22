<?php

namespace Modules\Core\Repositories;

use App\Repositories\BaseRepository;
use Modules\Core\Repositories\Contracts\TierRepositoryInterface;
use Modules\Core\Entities\Tier;

/** @property Tier $model */
class TierRepository extends BaseRepository implements TierRepositoryInterface
{
    public function model()
    {
        return Tier::class;
    }
}

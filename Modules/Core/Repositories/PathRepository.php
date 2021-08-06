<?php

namespace Modules\Core\Repositories;

use App\Repositories\BaseRepository;
use Modules\Core\Repositories\Contracts\PathRepositoryInterface;
use Modules\Core\Entities\Path;

/** @property Path $model */
class PathRepository extends BaseRepository implements PathRepositoryInterface
{
    public function model()
    {
        return Path::class;
    }
}

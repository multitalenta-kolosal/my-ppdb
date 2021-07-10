<?php

namespace Modules\Registrant\Repositories;

use App\Repositories\BaseRepository;
use Modules\Registrant\Repositories\Contract\RegistrantRepositoryInterface;
use Modules\Registrant\Entities\Registrant;

/** @property Registrant $model */
class RegistrantRepository extends BaseRepository implements RegistrantRepositoryInterface
{
    public function model()
    {
        return Registrant::class;
    }
}

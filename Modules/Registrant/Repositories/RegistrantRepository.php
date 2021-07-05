<?php

namespace Modules\Registrant\Repositories;

use Czim\Repository\BaseRepository;
use Modules\Registrant\Repositories\Contract\RegistrantRepositoryInterface;
use Modules\Registrant\Entities\Registrant;

/** @property Registrant $model */
class RegistrantRepository extends BaseRepository implements RegistrantRepositoryInterface
{
    public function model()
    {
        return Registrant::class;
    }

    public function trashed()
    {
        return $this->model()::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();
    }

    public function restore($id)
    {
        $registrants = $this->model()::withTrashed()->find($id);
        
        $registrants->restore();

        return $registrants;
    }
}

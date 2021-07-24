<?php

namespace Modules\Message\Repositories;

use App\Repositories\BaseRepository;
use Modules\Message\Repositories\Contracts\RegistrantMessageRepositoryInterface;
use Modules\Message\Entities\RegistrantMessage;

/** @property RegistrantMessage $model */
class RegistrantMessageRepository extends BaseRepository implements RegistrantMessageRepositoryInterface
{
    public function model()
    {
        return RegistrantMessage::class;
    }

    public function getBiggestUnitIncrement($unit_id)
    {
        return RegistrantMessage::where('unit_id', $unit_id)->withTrashed()->max('unit_increment');
    }

    public function getRegistrantMessagesByUnitQuery($unit_id){
        return RegistrantMessage::where('unit_id', $unit_id)->withTrashed();
    }
}

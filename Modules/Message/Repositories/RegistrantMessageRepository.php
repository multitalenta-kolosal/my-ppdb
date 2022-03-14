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

    public function getRegistrantMessagesByUnitQuery($unit_id){
        return RegistrantMessage::select('registrant_messages.*')
            ->join('registrants', 'registrants.registrant_id', 'registrant_messages.registrant_id')
            ->where('registrants.unit_id', $unit_id);
    }
}

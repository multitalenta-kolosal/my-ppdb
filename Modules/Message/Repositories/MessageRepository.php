<?php

namespace Modules\Message\Repositories;

use App\Repositories\BaseRepository;
use Modules\Message\Repositories\Contracts\MessageRepositoryInterface;
use Modules\Message\Entities\Message;

/** @property Message $model */
class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function model()
    {
        return Message::class;
    }
}

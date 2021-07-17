<?php

namespace Modules\Registrant\Events\Frontend;

use Illuminate\Queue\SerializesModels;
use Modules\Registrant\Entities\Registrant;

class RegistrantEnlist
{
    use SerializesModels;

    public $registrant;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Registrant $registrant)
    {
        $this->registrant = $registrant;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

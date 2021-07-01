<?php

namespace Modules\Registrant\Listeners\Backend;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

use Modules\Registrant\Events\Backend\RegistrantCreated;
use Modules\Registrant\Notifications\NotifyAdminYayasanNewRegistrant;

use Modules\Registrant\Entities\Registrant;

class NotifyAdminYayasan
{

    public $registrant;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $registrant = $event->registrant;

        auth()->user()->notify(new NotifyAdminYayasanNewRegistrant($registrant));
        
        Log::info('Listeners: NotifyAdminYayasan, Registrant: '.$registrant->name.', Handle Notification');
    }
}

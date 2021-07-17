<?php

namespace Modules\Registrant\Listeners\Frontend;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Models\User;

use Modules\Registrant\Events\Frontend\RegistrantEnlist;
use Modules\Registrant\Notifications\NotifyYayasanRegistrantEnlist;
use Modules\Registrant\Entities\Registrant;

class NotifyAdminYayasanEnlist
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
        
        $guest = User::findOrFail(1);
        $guest->notify(new NotifyYayasanRegistrantEnlist($registrant));
        
    }
}

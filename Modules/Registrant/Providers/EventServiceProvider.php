<?php

namespace Modules\Registrant\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

//Events
Use Modules\Registrant\Events\Backend\RegistrantCreated;
Use Modules\Registrant\Events\Frontend\RegistrantEnlist;

//Listeners
Use Modules\Registrant\Listeners\Backend\NotifyAdminYayasan;
Use Modules\Registrant\Listeners\Frontend\NotifyAdminYayasanEnlist;
Use Modules\Registrant\Listeners\Frontend\NotifyUnitYayasanEnlist;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RegistrantCreated::class => [
            NotifyAdminYayasan::class,
        ],
        RegistrantEnlist::class => [
            NotifyAdminYayasanEnlist::class, NotifyUnitYayasanEnlist::class,
        ],
    ];
}

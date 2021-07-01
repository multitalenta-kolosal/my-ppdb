<?php

namespace Modules\Registrant\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

//Events
Use Modules\Registrant\Events\Backend\RegistrantCreated;

//Listeners
Use Modules\Registrant\Listeners\Backend\NotifyAdminYayasan;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RegistrantCreated::class => [
            NotifyAdminYayasan::class,
        ]
    ];
}

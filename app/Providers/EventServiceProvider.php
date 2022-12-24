<?php

namespace App\Providers;

use App\Events\UserActivation;
use App\Listeners\front\SendSMSVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserActivation::class => [
            SendSMSVerificationNotification::class,
        ],
        'App\Events\OrderEvent'=>[]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

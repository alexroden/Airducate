<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Bus\Events\Assignments\AssignmentCompletedEvent' => [
            'App\Bus\Handlers\Events\Assignments\AssignmentCompletedEventHandler',
        ],
        'App\Bus\Events\Users\UserHasBeenInvitedEvent' => [
            'App\Bus\Handlers\Events\Users\UserHasBeenInvitedEventHandler',
        ],
        'App\Bus\Events\Users\UserHasLoggedInEvent' => [
            //
        ],
        'App\Bus\Events\Groups\UserGroupAssignedEvent' => [
            'App\Bus\Handlers\Events\Groups\UserGroupAssignedEventHandler',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}

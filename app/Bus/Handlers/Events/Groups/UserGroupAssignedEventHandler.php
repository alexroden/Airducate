<?php

namespace App\Bus\Handlers\Events\Groups;

use App\Bus\Events\Groups\UserGroupAssignedEvent;
use App\Notifications\Users\UserGroupAssignedNotification;

class UserGroupAssignedEventHandler
{
    /**
     * @param \App\Bus\Events\Groups\UserGroupAssignedEvent $event
     */
    public function handle(UserGroupAssignedEvent $event): void
    {
        $event->user->notify(new UserGroupAssignedNotification($event->user, $event->group));
    }
}

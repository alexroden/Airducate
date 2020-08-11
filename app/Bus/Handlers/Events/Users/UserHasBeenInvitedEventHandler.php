<?php

namespace App\Bus\Handlers\Events\Users;

use App\Bus\Events\Users\UserHasBeenInvitedEvent;
use App\Notifications\Users\InviteUserNotification;

class UserHasBeenInvitedEventHandler
{
    /**
     * @param \App\Bus\Events\Users\UserHasBeenInvitedEvent $event
     */
    public function handle(UserHasBeenInvitedEvent $event): void
    {
        $event->user->notify(new InviteUserNotification($event->user, $event->token));
    }
}

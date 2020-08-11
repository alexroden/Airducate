<?php

namespace App\Bus\Handlers\Events\Assignments;

use App\Bus\Events\Assignments\AssignmentCompletedEvent;
use App\Notifications\Assignments\AssignmentCompletedNotification;

class AssignmentCompletedEventHandler
{
    /**
     * @param \App\Bus\Events\Assignments\AssignmentCompletedEvent $event
     */
    public function handle(AssignmentCompletedEvent $event): void
    {
        $event->user->notify(new AssignmentCompletedNotification($event->assignment, $event->user));
    }
}

<?php

namespace App\Notifications\Assignments;

use App\Models\Assignment;
use App\Models\User;
use App\Util\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\Assignment
     */
    protected $assignment;

    /**
     * @var \App\Models\User
     */
    protected $user;


    /**
     * @param \App\Models\Assignment $assignment
     * @param \App\Models\User       $user
     */
    public function __construct(Assignment $assignment, User $user)
    {
        $this->assignment = $assignment;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        $via = [];
        if (Environment::isProduction()) {
            $via = array_merge($via, [
                'mail'
            ]);
        }

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
            ->from('no_reply@airducate.com', 'Airducate')
            ->greeting('Congratulation! 🎉')
            ->line("You have completed {$this->assignment->name}.");
    }
}

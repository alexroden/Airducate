<?php

namespace App\Notifications\Users;

use App\Models\Group;
use App\Models\User;
use App\Util\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserGroupAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * @var \App\Models\Group
     */
    public $group;

    /**
     * @param \App\Models\User  $user
     * @param \App\Models\Group $group
     */
    public function __construct(User $user, Group $group)
    {
        $this->user = $user;
        $this->group = $group;
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
    public function toMail(): MailMessage
    {
        $message =  (new MailMessage)
            ->from('no_reply@airducate.com', 'Airducate')
            ->greeting('Hello!')
            ->line('You have been assigned training:');

        foreach($this->group->modules as $module) {
            $message->line(" - {$module->name}");
        }

        $url = route('dashboard', ['user' => $this->user]);
        $message->action('Go To Training', $url);

        return $message;
    }
}

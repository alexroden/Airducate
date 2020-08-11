<?php

namespace App\Notifications\Users;

use App\Models\User;
use App\Util\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param \App\Models\User $user
     * @param string           $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
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
        $url = route('register', ['token' => $this->token]);

        return (new MailMessage)
            ->from('no_reply@airducate.com', 'Airducate')
            ->greeting('Hello!')
            ->line('You have been invited to Airducate!')
            ->action('Complete Registration', $url);
    }
}

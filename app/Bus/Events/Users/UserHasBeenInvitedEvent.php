<?php

namespace App\Bus\Events\Users;

use App\Models\User;

final class UserHasBeenInvitedEvent implements UserEventInterface
{
    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @var string
     */
    public $token;

    /**
     * @param \App\Models\User $user
     * @param string           $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}

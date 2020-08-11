<?php

namespace App\Bus\Events\Users;

use App\Models\User;

final class UserHasLoggedInEvent implements UserEventInterface
{
    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

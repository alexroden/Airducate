<?php

namespace App\Bus\Events\Groups;

use App\Models\Group;
use App\Models\User;

final class UserGroupAssignedEvent implements GroupEventInterface
{
    /**
     * @var \App\Models\User
     */
    public $user;

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
}

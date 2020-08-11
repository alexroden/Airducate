<?php

namespace App\Bus\Events\Assignments;

use App\Models\Assignment;
use App\Models\User;

final class AssignmentCompletedEvent implements AssignmentEventInterface
{
    /**
     * @var \App\Models\Assignment
     */
    public $assignment;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @param \App\Models\Assignment $assignment
     * @param \App\Models\User       $user
     */
    public function __construct(Assignment $assignment, User $user)
    {
        $this->assignment = $assignment;
        $this->user = $user;
    }
}

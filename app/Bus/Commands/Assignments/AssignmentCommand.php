<?php

namespace App\Bus\Commands\Assignments;

use App\Models\Assignment;
use App\Models\User;

class AssignmentCommand
{
    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @var \App\Models\Assignment
     */
    public $assignment;

    /**
     * @var float
     */
    public $progress;

    /**
     * @var float
     */
    public $score;

    /**
     * @param \App\Models\User       $user
     * @param \App\Models\Assignment $assignment
     * @param float|null             $progress
     * @param float|null             $score
     */
    public function __construct(
        User $user,
        Assignment $assignment,
        ?float $progress = null,
        ?float $score = null
    ) {
        $this->user = $user;
        $this->assignment = $assignment;
        $this->progress = $progress;
        $this->score = $score;
    }
}

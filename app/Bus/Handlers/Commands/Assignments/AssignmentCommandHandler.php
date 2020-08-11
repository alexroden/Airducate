<?php

namespace App\Bus\Handlers\Commands\Assignments;

use App\Bus\Commands\Assignments\AssignmentCommand;
use App\Bus\Events\Assignments\AssignmentCompletedEvent;
use App\Models\Grade;
use Carbon\Carbon;

class AssignmentCommandHandler
{
    /**
     * @param \App\Bus\Commands\Assignments\AssignmentCommand $command
     */
    public function handle(AssignmentCommand $command): void
    {
        $grade = Grade::updateOrCreate([
            'user_id'       => $command->user->id,
            'assignment_id' => $command->assignment->id,
        ], $this->filter($command));

        if ($grade->progress >= Grade::THRESHOLD) {
            $grade->update(['completed_at' => Carbon::now()]);

            event(new AssignmentCompletedEvent($command->assignment, $command->user));
        }
    }

    /**
     * @param \App\Bus\Commands\Assignments\AssignmentCommand $command
     *
     * @return array
     */
    protected function filter(AssignmentCommand $command): array
    {
        $params = [
            'progress' => $command->progress,
            'score'    => $command->score,
        ];

        return array_filter($params, function ($val) {
            return $val !== null && $val !== '';
        });
    }
}

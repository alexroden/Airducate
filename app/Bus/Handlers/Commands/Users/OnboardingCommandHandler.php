<?php

namespace App\Bus\Handlers\Commands\Users;

use App\Bus\Commands\Users\LoginCommand;
use App\Bus\Commands\Users\OnboardingCommand;
use App\Bus\Events\Groups\UserGroupAssignedEvent;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Module;
use App\Models\User;
use App\Models\UserGroup;

class OnboardingCommandHandler
{
    /**
     * @param \App\Bus\Commands\Users\OnboardingCommand $command
     *
     * @throws \App\Bus\Exceptions\User\InvalidUserCredentialsException
     */
    public function handle(OnboardingCommand $command): void
    {
        $user = User::findByToken($command->user);
        $user->update(['password' => $command->password]);

        if (!empty($command->questions)) {
            $questionOne = Group::ONBOARD_QUESTION_MAPPING[Group::QUESTIONS[0]][$command->questions[0][0]];
            $questionTwo = array_keys(Group::ONBOARD_QUESTION_MAPPING[Group::QUESTIONS[1]][$questionOne])[$command->questions[1][0]];

            $group = Group::find(Group::GROUPS[$questionTwo]);

            UserGroup::create([
                'user_id'  => $user->id,
                'group_id' => $group->id,
            ]);

            $group->modules->flatMap(function (Module $module) {
                return $module->assignments;
            })->each(function (Assignment $assignment) use ($user) {
                Grade::create([
                    'user_id'       => $user->id,
                    'assignment_id' => $assignment->id,
                ]);
            });

            event(new UserGroupAssignedEvent($user, $group));
        }

        execute(new LoginCommand(
            $user->email,
            $command->password,
        ));
    }
}

<?php

use App\Enums\Roles;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Module;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        UserGroup::truncate();
        Grade::truncate();

        $data = [
            [
                'token'      => '9202587b-ef37-41ed-a24f-4620067dbeac',
                'first_name' => 'Test',
                'last_name'  => 'User',
                'email'      => 'test@test.com',
                'password'   => 'Password123!',
            ],
        ];

        $group = Group::find(1);
        foreach ($data as $user) {
            /** @var \App\Models\User $user */
            $user = User::create($user);
            $user->assignRole(Roles::ADMINISTRATOR);
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
        }
    }
}

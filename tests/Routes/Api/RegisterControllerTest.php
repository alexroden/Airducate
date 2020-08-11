<?php

namespace Tests\Routes\Api;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleAssignment;
use App\Models\Token;
use App\Models\User;
use App\Models\UserGroup;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\Routes\AbstractRouteTestCase;
use Tests\Routes\Concerns\Session;

class RegisterControllerTest extends AbstractRouteTestCase
{
    use Session;

    public function testRegister()
    {
        $this->setToken();

        $user = factory(User::class)->create();
        $group = factory(Group::class)->create([
            'name' => Group::GROUP_PILOTS,
        ]);

        $module = factory(Module::class)->create([
            'token' => 'foo',
            'name'  => 'Foo',
        ]);
        factory(GroupModule::class)->create([
            'group_id'  => $group->id,
            'module_id' => $module->id,
        ]);

        $assignment = factory(Assignment::class)->create([
            'token'       => 'foo',
            'type'        => Assignment::TYPE_VIDEO,
            'name'        => 'Foo',
            'description' => null,
            'source'      => 'https://foo.bar',
            'content'     => null,
            'cover_image' => 'https://foo.bar',
            'length'      => 3.21,
        ]);
        factory(ModuleAssignment::class)->create([
            'module_id'     => $module->id,
            'assignment_id' => $assignment->id,
        ]);

        $response = $this->post('/api/register', [
            'user'      => $user->token,
            'password'  => 'Password123!',
            'questions' => [
                [0], [0],
            ],
        ], [
            'Guest-Token' => 'foo',
        ]);

        $response->assertOk();

        // User assigned to group.
        $this->assertEquals(1, $user->groups()->count());
        $this->assertEquals(1, $user->groups()->first()->id);

        // Created grade.
        $grade = Grade::find(1);
        $this->assertTrue($grade !== null);
    }
}

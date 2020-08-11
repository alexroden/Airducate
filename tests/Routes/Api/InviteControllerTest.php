<?php

namespace Tests\Routes\Api;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\Token;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\Routes\AbstractRouteTestCase;

class InviteControllerTest extends AbstractRouteTestCase
{
    public function testInvite()
    {
        $user = $this->asAuthedUser();

        $role = factory(Role::class)->create(['name' => Roles::ADMINISTRATOR]);
        $permission = factory(Permission::class)->create(['name' => Permissions::INVITE_USERS]);

        $role->givePermissionTo($permission);
        $user->assignRole($role);


        $response = $this->post('/api/invite', [
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
        ], [
            'User-Token' => $user->token,
        ]);

        $response->assertStatus(204);

        // Created user.
        $newUser = User::find(2);
        $this->assertTrue(!!$newUser);

        // Created token.
        $token = Token::find(1);
        $this->assertTrue(!!$token);
    }
}

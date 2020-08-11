<?php

namespace Tests\Routes\Api;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\Group;
use App\Models\Token;
use App\Models\User;
use App\Models\UserGroup;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\Routes\AbstractRouteTestCase;
use Tests\Routes\Concerns\Session;

class LoginControllerTest extends AbstractRouteTestCase
{
    use Session;

    public function testLogin()
    {
        $this->setToken();

        factory(User::class)->create([
            'email'    => 'foo@bar.com',
            'password' => 'Password123!',
        ]);

        $response = $this->post('/api/login', [
            'email'     => 'foo@bar.com',
            'password'  => 'Password123!',
        ], [
            'Guest-Token' => 'foo',
        ]);

        $response->assertOk();
    }
}

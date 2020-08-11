<?php


namespace Tests\Routes;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

abstract class AbstractRouteTestCase extends AbstractTestCase
{
    use DatabaseMigrations;

    /**
     * @param array $params
     *
     * @return \App\Models\User
     */
    protected function asAuthedUser(array $params = []): User
    {
        $user = factory(User::class)->create($params);
        $this->be($user);

        return $user;
    }
}

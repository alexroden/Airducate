<?php

namespace Tests\Routes\Api;

use App\Models\Assignment;
use App\Models\Category;
use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleAssignment;
use App\Models\Type;
use App\Models\UserGroup;
use Carbon\Carbon;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Routes\AbstractRouteTestCase;
use Tests\Routes\Concerns\Session;

class ModuleControllerTest extends AbstractRouteTestCase
{
    use Session;
    use MatchesSnapshots;

    public function testGet()
    {
        Carbon::setTestNow(Carbon::parse('2020-08-08 00:00:00'));

        $user = $this->asAuthedUser();
        $group = factory(Group::class)->create();
        factory(UserGroup::class)->create([
            'user_id'   => $user->id,
            'group_id' => $group->id,
        ]);

        $module = factory(Module::class)->create([
            'token' => 'foo',
            'name'  => 'Foo',
        ]);
        factory(GroupModule::class)->create([
            'group_id'  => $group->id,
            'module_id' => $module->id,
        ]);

        $response = $this->get('/api/modules', [
            'User-Token' => $user->token,
        ]);

        $response->assertOk();
        $this->assertMatchesJsonSnapshot($response->getContent());
    }

    public function testAssignments()
    {
        Carbon::setTestNow(Carbon::parse('2020-08-08 00:00:00'));

        $user = $this->asAuthedUser();

        $module = factory(Module::class)->create();
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

        $response = $this->get("/api/modules/{$module->token}/assignments", [
            'User-Token' => $user->token,
        ]);

        $response->assertOk();
        $this->assertMatchesJsonSnapshot($response->getContent());
    }

    public function testFilters()
    {
        Carbon::setTestNow(Carbon::parse('2020-08-08 00:00:00'));

        $user = $this->asAuthedUser();

        factory(Category::class)->create([
            'name' => 'Health & Safety',
        ]);
        factory(Type::class)->create([
            'name' => 'General',
        ]);

        $response = $this->get("/api/filters", [
            'User-Token' => $user->token,
        ]);

        $response->assertOk();
        $this->assertMatchesJsonSnapshot($response->getContent());
    }
}

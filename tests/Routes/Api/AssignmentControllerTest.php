<?php

namespace Tests\Routes\Api;

use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleAssignment;
use App\Models\UserGroup;
use Carbon\Carbon;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Routes\AbstractRouteTestCase;
use Tests\Routes\Concerns\Session;

class AssignmentControllerTest extends AbstractRouteTestCase
{
    use MatchesSnapshots;

    public function testAssignments()
    {
        Carbon::setTestNow(Carbon::parse('2020-08-08 00:00:00'));

        $user = $this->asAuthedUser();

        $assignment = factory(Assignment::class)->create([
            'type'        => Assignment::TYPE_VIDEO,
            'name'        => 'Foo',
            'description' => null,
            'source'      => 'https://foo.bar',
            'content'     => null,
            'cover_image' => 'https://foo.bar',
            'length'      => 3.21,
        ]);

        $response = $this->post("/api/assignments/{$assignment->token}", [
            'progress' => 1,
            'score'    => 10,
        ], [
            'User-Token' => $user->token,
        ]);

        $response->assertStatus(204);

        // Create grade.
        $grade = Grade::find(1);
        $this->assertTrue(!!$grade);
    }

    public function testAssignmentGrade()
    {
        Carbon::setTestNow(Carbon::parse('2020-08-08 00:00:00'));

        $user = $this->asAuthedUser();

        $assignment = factory(Assignment::class)->create([
            'type'        => Assignment::TYPE_VIDEO,
            'name'        => 'Foo',
            'description' => null,
            'source'      => 'https://foo.bar',
            'content'     => null,
            'cover_image' => 'https://foo.bar',
            'length'      => 3.21,
        ]);

        factory(Grade::class)->create([
            'user_id'       => $user->id,
            'assignment_id' => $assignment->id,
            'progress'      => 1,
            'score'         => null,
            'completed_at'  => Carbon::now(),
        ]);

        $response = $this->get("/api/assignments/{$assignment->token}", [
            'User-Token' => $user->token,
        ]);

        $response->assertOk();
        $this->assertMatchesJsonSnapshot($response->getContent());
    }
}

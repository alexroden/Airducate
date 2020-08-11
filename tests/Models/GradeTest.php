<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class GradeTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new Grade());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The user id field is required.',
            'The assignment id field is required.',
        ];

        try {
            Grade::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The user id must be an integer.',
            'The assignment id field is required.',
            'The progress must be a number.',
        ];

        try {
            Grade::create([
                'user_id'  => 'foo',
                'progress' => 'bar',
            ]);
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithGoodData()
    {
        Carbon::getTestNow($c = Carbon::now());

        $expected = [
            'id'            => 1,
            'user_id'       => 1,
            'assignment_id' => 1,
            'progress'      => 9.5,
            'score'         => 9.5,
            'updated_at'    => (string) $c,
            'created_at'    => (string) $c,

        ];

        $item = Grade::create([
            'user_id'       => 1,
            'assignment_id' => 1,
            'progress'      => 9.5,
            'score'         => 9.5,
        ]);

        $this->assertInstanceOf(Grade::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }

    public function testAssignmentRelation()
    {
        $assignment = factory(Assignment::class)->create();
        $grade = factory(Grade::class)->create([
            'assignment_id' => $assignment
        ]);

        $this->assertTrue(!!$grade->assignment);
        $this->assertEquals($assignment->id, $grade->assignment->id);
    }

    public function testUserRelation()
    {
        $user = factory(User::class)->create();
        $grade = factory(Grade::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue(!!$grade->user);
        $this->assertEquals($user->id, $grade->user->id);
    }
}

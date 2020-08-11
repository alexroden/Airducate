<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\AssignmentType;
use App\Models\GroupModule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class AssignmentTypeTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new AssignmentType());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The assignment id field is required.',
            'The type id field is required.',
        ];

        try {
            AssignmentType::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The assignment id must be an integer.',
            'The type id field is required.',
        ];

        try {
            AssignmentType::create([
                'assignment_id' => 'foo',
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
            'assignment_id' => 1,
            'type_id'       => 1,
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,

        ];

        $item = AssignmentType::create([
            'assignment_id' => 1,
            'type_id'       => 1,
        ]);

        $this->assertInstanceOf(AssignmentType::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }
}

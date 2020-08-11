<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\AssignmentCategory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Tests\AbstractTestCase;

class AssignmentCategoryTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new AssignmentCategory());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The assignment id field is required.',
            'The category id field is required.',
        ];

        try {
            AssignmentCategory::create();
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
            'The category id field is required.',
        ];

        try {
            AssignmentCategory::create([
                'assignment_id' => 'Foo',
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
            'category_id'   => 1,
            'updated_at' => (string) $c,
            'created_at' => (string) $c,

        ];

        $item = AssignmentCategory::create([
            'assignment_id' => 1,
            'category_id'   => 1,
        ]);

        $this->assertInstanceOf(AssignmentCategory::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }
}

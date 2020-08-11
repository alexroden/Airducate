<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Assignment;
use App\Models\AssignmentCategory;
use App\Models\Category;
use App\Models\Module;
use App\Models\ModuleCategory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class CategoryTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new Category());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The name field is required.',
        ];

        try {
            Category::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The name must be a string.',
        ];

        try {
            Category::create([
                'name' => 123,
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
            'id'          => 1,
            'name'        => 'Foo',
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,

        ];

        $item = Category::create([
            'name' => 'Foo',
        ]);

        $this->assertInstanceOf(Category::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }

    public function testAssignmentsRelation()
    {
        $assignment = factory(Assignment::class)->create();
        $category = factory(Category::class)->create();
        factory(AssignmentCategory::class)->create([
            'assignment_id' => $assignment->id,
            'category_id'   => $category->id,
        ]);

        $this->assertEquals(1, $category->assignments()->count());
        $this->assertEquals($assignment->id, $category->assignments()->first()->id);
    }

    public function testModulesRelation()
    {
        $module = factory(Module::class)->create();
        $category = factory(Category::class)->create();
        factory(ModuleCategory::class)->create([
            'module_id'   => $module->id,
            'category_id' => $category->id,
        ]);

        $this->assertEquals(1, $category->modules()->count());
        $this->assertEquals($module->id, $category->modules()->first()->id);
    }
}

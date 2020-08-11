<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Assignment;
use App\Models\AssignmentCategory;
use App\Models\AssignmentType;
use App\Models\Category;
use App\Models\Module;
use App\Models\ModuleAssignment;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class AssignmentTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new Assignment());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The type field is required.',
            'The name field is required.',
        ];

        try {
            Assignment::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The type must be an integer.',
            'The name field is required.',
        ];

        try {
            Assignment::create([
                'type' => 'Foo',
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
            'token'       => 'foo',
            'type'        => Assignment::TYPE_LINK,
            'name'        => 'Foo',
            'description' => 'Foo Bar',
            'source'      => 'https://foo.bar',
            'content'     => '# Test',
            'cover_image' => 'https://foo.bar',
            'length'      => 1.5,
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,
            'modal'       => 'link-modal'

        ];

        $item = Assignment::create([
            'token'       => 'foo',
            'type'        => Assignment::TYPE_LINK,
            'name'        => 'Foo',
            'description' => 'Foo Bar',
            'source'      => 'https://foo.bar',
            'content'     => '# Test',
            'cover_image' => 'https://foo.bar',
            'length'      => 1.5,
        ]);

        $this->assertInstanceOf(Assignment::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }

    public function testCategoriesRelation()
    {
        $assignment = factory(Assignment::class)->create();
        $category = factory(Category::class)->create();
        factory(AssignmentCategory::class)->create([
            'assignment_id' => $assignment->id,
            'category_id'   => $category->id,
        ]);

        $this->assertEquals(1, $assignment->categories()->count());
        $this->assertEquals($category->id, $assignment->categories()->first()->id);
    }

    public function testModulesRelation()
    {
        $module = factory(Module::class)->create();
        $assignment = factory(Assignment::class)->create();
        factory(ModuleAssignment::class)->create([
            'module_id'     => $module->id,
            'assignment_id' => $assignment->id,
        ]);

        $this->assertEquals(1, $assignment->modules()->count());
        $this->assertEquals($module->id, $assignment->modules()->first()->id);
    }

    public function testTypesRelation()
    {
        $assignment = factory(Assignment::class)->create();
        $type = factory(Type::class)->create();
        factory(AssignmentType::class)->create([
            'assignment_id' => $assignment->id,
            'type_id'       => $type->id,
        ]);

        $this->assertEquals(1, $assignment->types()->count());
        $this->assertEquals($type->id, $assignment->types()->first()->id);
    }
}

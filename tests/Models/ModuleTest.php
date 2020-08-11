<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Assignment;
use App\Models\Category;
use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleAssignment;
use App\Models\ModuleCategory;
use App\Models\ModuleType;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class ModuleTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new Module());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The name field is required.',
        ];

        try {
            Module::create();
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
            Module::create([
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
            'token'       => 'foo',
            'name'        => 'Foo',
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,
            'route'       => 'http://localhost/modules/foo'
        ];

        $item = Module::create([
            'token' => 'foo',
            'name'  => 'Foo',
        ]);

        $this->assertInstanceOf(Module::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }

    public function testAssignmentsRelation()
    {
        $module = factory(Module::class)->create();
        $assignment = factory(Assignment::class)->create();
        factory(ModuleAssignment::class)->create([
            'module_id'     => $module->id,
            'assignment_id' => $assignment->id,
        ]);

        $this->assertEquals(1, $module->assignments()->count());
    }

    public function testCategoriesRelation()
    {
        $module = factory(Module::class)->create();
        $category = factory(Category::class)->create();
        factory(ModuleCategory::class)->create([
            'module_id'   => $module->id,
            'category_id' => $category->id,
        ]);

        $this->assertEquals(1, $module->categories()->count());
    }

    public function testGroupsRelation()
    {
        $module = factory(Module::class)->create();
        $group = factory(Group::class)->create();
        factory(GroupModule::class)->create([
            'group_id'  => $group->id,
            'module_id' => $module->id,
        ]);

        $this->assertEquals(1, $module->groups()->count());
        $this->assertEquals($group->id, $module->groups()->first()->id);
    }

    public function testTypesRelation()
    {
        $module = factory(Module::class)->create();
        $type = factory(Type::class)->create();
        factory(ModuleType::class)->create([
            'module_id' => $module->id,
            'type_id'   => $type->id,
        ]);

        $this->assertEquals(1, $module->types()->count());
        $this->assertEquals($type->id, $module->types()->first()->id);
    }
}

<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Assignment;
use App\Models\AssignmentType;
use App\Models\Module;
use App\Models\ModuleType;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class TypeTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new Type);
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The name field is required.',
        ];

        try {
            Type::create();
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
            Type::create([
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

        $item = Type::create([
            'name' => 'Foo',
        ]);

        $this->assertInstanceOf(Type::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }

    public function testAssignmentsRelation()
    {
        $assignment = factory(Assignment::class)->create();
        $type = factory(Type::class)->create();
        factory(AssignmentType::class)->create([
            'assignment_id' => $assignment->id,
            'type_id'       => $type->id,
        ]);

        $this->assertEquals(1, $type->assignments()->count());
        $this->assertEquals($assignment->id, $type->assignments()->first()->id);
    }

    public function testModulesRelation()
    {
        $module = factory(Module::class)->create();
        $type = factory(Type::class)->create();
        factory(ModuleType::class)->create([
            'module_id' => $module->id,
            'type_id'   => $type->id,
        ]);

        $this->assertEquals(1, $type->modules()->count());
        $this->assertEquals($module->id, $type->modules()->first()->id);
    }
}

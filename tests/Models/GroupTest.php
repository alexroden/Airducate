<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\User;
use App\Models\UserGroup;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class GroupTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new Group());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The name field is required.',
        ];

        try {
            Group::create();
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
            Group::create([
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

        $item = Group::create([
            'name' => 'Foo',
        ]);

        $this->assertInstanceOf(Group::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }

    public function testModulesRelation()
    {
        $group = factory(Group::class)->create();
        $module = factory(Module::class)->create();
        factory(GroupModule::class)->create([
            'group_id'  => $group->id,
            'module_id' => $module->id,
        ]);

        $this->assertEquals(1, $group->modules()->count());
        $this->assertEquals($module->id, $group->modules()->first()->id);
    }

    public function testUsersRelation()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        factory(UserGroup::class)->create([
            'user_id'  => $user->id,
            'group_id' => $group->id,
        ]);

        $this->assertEquals(1, $group->users()->count());
        $this->assertEquals($user->id, $group->users()->first()->id);
    }
}

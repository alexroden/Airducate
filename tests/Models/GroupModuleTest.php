<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\GroupModule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class GroupModuleTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new GroupModule());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The group id field is required.',
            'The module id field is required.',
        ];

        try {
            GroupModule::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The group id must be an integer.',
            'The module id field is required.',
        ];

        try {
            GroupModule::create([
                'group_id' => 'foo',
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
            'group_id'    => 1,
            'module_id'    => 1,
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,

        ];

        $item = GroupModule::create([
            'group_id'  => 1,
            'module_id' => 1,
        ]);

        $this->assertInstanceOf(GroupModule::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }
}

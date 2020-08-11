<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\ModuleType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class ModuleTypeTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new ModuleType());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The module id field is required.',
            'The type id field is required.',
        ];

        try {
            ModuleType::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The module id must be an integer.',
            'The type id field is required.',
        ];

        try {
            ModuleType::create([
                'module_id' => 'foo',
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
            'module_id'   => 1,
            'type_id' => 1,
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,

        ];

        $item = ModuleType::create([
            'module_id'   => 1,
            'type_id' => 1,
        ]);

        $this->assertInstanceOf(ModuleType::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }
}

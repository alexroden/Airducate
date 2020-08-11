<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\UserGroup;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class UserGroupTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new UserGroup());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The user id field is required.',
            'The group id field is required.',
        ];

        try {
            UserGroup::create();
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
            'The group id field is required.',
        ];

        try {
            UserGroup::create([
                'user_id' => 'foo',
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
            'user_id'   => 1,
            'group_id'    => 1,
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,

        ];

        $item = UserGroup::create([
            'user_id'  => 1,
            'group_id' => 1,
        ]);

        $this->assertInstanceOf(UserGroup::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }
}

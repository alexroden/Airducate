<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Grade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\AbstractTestCase;

class UserTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new User());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The first name field is required.',
            'The last name field is required.',
            'The email field is required.',
        ];

        try {
            User::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The first name must be a string.',
            'The last name field is required.',
            'The email must be a valid email address.',
        ];

        try {
            User::create([
                'first_name' => 123,
                'email'      => 'testing',
                'password'   => 'Password123!',
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
            'token'       => Uuid::NIL,
            'first_name'  => 'Foo',
            'last_name'   => 'Bar',
            'email'       => 'test@test.com',
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,
            'full_name' => 'Foo Bar',
        ];

        $item = User::create([
            'token'       => Uuid::NIL,
            'first_name'  => 'Foo',
            'last_name'   => 'Bar',
            'email'       => 'test@test.com',
            'password'    => 'Password123!',
        ]);

        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }

    public function testGrades()
    {
        $user = factory(User::class)->create();
        $grade = factory(Grade::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals(1, $user->grades()->count());
        $this->assertEquals($grade->id, $user->grades()->first()->id);
    }
}

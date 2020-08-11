<?php

namespace Tests\Models;

use AltThree\TestBench\ValidationTrait;
use AltThree\Validator\ValidationException;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\AbstractTestCase;

class TokenTest extends AbstractTestCase
{
    use DatabaseMigrations;
    use ValidationTrait;

    public function testValidation()
    {
        $this->checkRules(new Token());
    }

    public function testSaveWithNothing()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The type field is required.',
            'The token field is required.',
        ];

        try {
            Token::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithBadData()
    {
        $this->expectException(ValidationException::class);

        $expected = [
            'The type must be a string.',
            'The token field is required.',
        ];

        try {
            Token::create([
                'type' => 123,
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
            'type'        => Token::TYPE_ONE_TIME,
            'token'       => Token::generateToken(['testing']),
            'updated_at'  => (string) $c,
            'created_at'  => (string) $c,

        ];

        $item = Token::create([
            'type'        => Token::TYPE_ONE_TIME,
            'token'       => Token::generateToken(['testing']),
        ]);

        $this->assertInstanceOf(Token::class, $item);
        $this->assertEquals($expected, $item->toArray());
    }
}

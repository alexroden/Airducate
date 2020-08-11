<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Assignment;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Assignment::class, function (Faker $faker) {
    return [
        'type'        => Assignment::TYPE_LINK,
        'name'        => $faker->word,
        'description' => $faker->sentence,
        'source'      => $faker->url,
        'cover_image' => $faker->url,
        'length'      => $faker->randomFloat(),
    ];
});

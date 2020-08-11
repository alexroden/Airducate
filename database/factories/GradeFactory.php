<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Assignment;
use App\Models\Grade;
use App\Models\User;
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

$factory->define(Grade::class, function (Faker $faker) {
    return [
        'user_id'       => factory(User::class)->create()->id,
        'assignment_id' => factory(Assignment::class)->create()->id,
        'progress'      => $faker->randomFloat(),
        'score'         => $faker->randomFloat(),
    ];
});

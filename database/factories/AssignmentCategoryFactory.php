<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Assignment;
use App\Models\AssignmentCategory;
use App\Models\Category;
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

$factory->define(AssignmentCategory::class, function (Faker $faker) {
    return [
        'assignment_id' => factory(Assignment::class)->create()->id,
        'category_id'   => factory(Category::class)->create()->id,
    ];
});

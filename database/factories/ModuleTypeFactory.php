<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Module;
use App\Models\ModuleType;
use App\Models\Type;
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

$factory->define(ModuleType::class, function (Faker $faker) {
    return [
        'module_id' => factory(Module::class)->create()->id,
        'type_id'   => factory(Type::class)->create()->id,
    ];
});

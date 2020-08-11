<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
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

$factory->define(GroupModule::class, function (Faker $faker) {
    return [
        'group_id'  => factory(Group::class)->create()->id,
        'module_id' => factory(Module::class)->create()->id,
    ];
});

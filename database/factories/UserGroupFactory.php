<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
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

$factory->define(UserGroup::class, function (Faker $faker) {
    return [
        'user_id'  => factory(User::class)->create()->id,
        'group_id' => factory(Group::class)->create()->id,
    ];
});

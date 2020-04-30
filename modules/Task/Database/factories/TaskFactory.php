<?php

use Faker\Generator as Faker;
use Modules\Task\Entities\Task;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your module. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Modules\Task\Entities\Task::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['work', 'shoppping']),
        'content' => $faker->jobTitle,
        'sort_order' => $faker->randomDigit(),
        'done' => $faker->boolean(),
    ];
});

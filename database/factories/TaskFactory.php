<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => $faker->randomElement(['active', 'completed', 'on hold']),
        'date' => $faker->unixTime(),
        'created_at' => $faker->unixTime(new DateTime()),
        'updated_at' => $faker->unixTime(new DateTime('+3 weeks')),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    $first_name = $faker->firstName;
    $last_name  = $faker->lastName;

    $random = random_int(1, 3);

    return [
        'first_name'      => $first_name,
        'last_name'       => $last_name,
        'company_id'      => $random,
        'email'           => $faker->unique()->safeEmail,
        'phone'           => $faker->phoneNumber,
        'created_at'      => $faker->dateTimeBetween('-7 days', 'now', 'Asia/Manila')
    ];
});

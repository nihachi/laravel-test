<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    $company = $faker->company;
    $width = 150;
    $height = 150;
    $random = random_int(1, 3);

    return [
        'name'            => $company,
        'email'           => $faker->unique()->safeEmail,
        'logo'            => $faker->imageUrl($width, $height, 'cats'),
        'created_at'      => $faker->dateTimeBetween('-7 days', 'now', 'Asia/Manila')
    ];
});

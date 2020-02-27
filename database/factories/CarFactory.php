<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
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

$factory->define(Car::class, function (Faker $faker) {
    return [
        'brand' => $faker->randomElement([
            'Perodua',
            'Proton',
            'Toyota',
            'Honda',
            'Lamborghini',
        ]),
        'model' => $faker->city(),
        'cc' => $faker->numberBetween(1, 100) * 100,
        'color' => $faker->colorName(),
    ];
});

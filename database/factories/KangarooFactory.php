<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Kangaroo;
use Faker\Generator as Faker;
use App\Enums\Gender;
use App\Enums\FriendlinessLevel;

$factory->define(Kangaroo::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'nickname' => $faker->name,
        'weight' => $faker->numerify('##.##'),
        'height' => $faker->numerify('##.##'),
        'gender' => collect(Gender::all())->random(),
        'color' => $faker->colorName,
        'friendliness' => collect(FriendlinessLevel::all())->random(),
        'birthday' => now()->subYears(3)->format('Y-m-d'),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Kasus;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Kasus::class, function (Faker $faker) {
    return [
        'total_case' => rand(0, 50),
        'new_case' => rand(0, 50),
        'total_death' => rand(0, 50),
        'new_death' => rand(0, 50),
        'total_recovered' => rand(0, 50),
        'active_case' => rand(0, 50),
        'critical_case' => rand(0, 50),
        'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp()))->addHours( $faker->numberBetween( 1, 8 ) )
    ];
});

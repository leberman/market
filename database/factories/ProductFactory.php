<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'seller_id' => 1,
        'user_id' => $faker->numberBetween(1,9),
        'title' => $faker->text(35),
        'slug' => $faker->slug,
        'description' => $faker->text,
        'price' => 45000,
        'status' => 1,
    ];
});

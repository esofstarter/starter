<?php
use App\Applications\Post\Model\Category;
use Faker\Generator as Faker;

// use seed() method for generating consistent data
// $factory->faker->seed('1234');
$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'slug' => strtolower(implode('-', explode(' ', $faker->name)))
    ];
});

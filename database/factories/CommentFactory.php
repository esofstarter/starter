<?php

use Faker\Generator as Faker;

$factory->define(\App\Applications\Post\Model\Posts\Comment::class, function (Faker $faker) {
    return [
        //
        'comment' => $faker->sentence()
    ];
});

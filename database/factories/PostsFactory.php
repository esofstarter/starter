<?php
use App\Applications\User\Model\User;
use App\Applications\Post\Model\Category;
use Faker\Generator as Faker;

$factory->define(\App\Applications\Post\Model\Posts::class, function (Faker $faker) {
    return [
        //
        'title'=> $faker->name,
        'body' => $faker->paragraph(),
        'user_id' => User::all(['id'])->random(),
        // 'categories' => Category::all(['id'])->random(),
        // 'image' => $faker->image(200,300)
    ];
});

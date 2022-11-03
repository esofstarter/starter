<?php

use App\Applications\Post\Model\Category;
use App\Applications\Post\Model\Posts;
use App\PostsCategories;
use Faker\Generator as Faker;

$factory->define(PostsCategories::class, function (Faker $faker) {
    return [
        'category_id'=> Category::all(['id'])->random(),
        'post_id'=> Posts::all(['id'])->random(),
    ];
});

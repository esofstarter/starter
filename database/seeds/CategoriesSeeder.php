<?php

use Illuminate\Database\Seeder;
use App\Applications\Post\Model\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Category::class, 5)->create();

        /** @var Category $News */
        $News = Category::create([
            'title' => 'News',
            'slug' => strtolower(implode('-', explode(' ', 'news')))
        ]);

        /** @var Category $Entertainment */
        $Entertainment = Category::create([
            'title' => 'Entertainment',
            'slug' => strtolower(implode('-', explode(' ', 'Entertainment')))
        ]);

        /** @var Category $Sports */
        $Sports = Category::create([
            'title' => 'Sports',
            'slug' => strtolower(implode('-', explode(' ', 'Sports')))
        ]);

        /** @var Category $Video */
        $Video = Category::create([
            'title' => 'Video',
            'slug' => strtolower(implode('-', explode(' ', 'Video')))
        ]);
    }
}

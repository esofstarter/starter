<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostsCategories extends Model
{
    //
    public $table='category_post';
    public $timestamps = true;
    protected $fillable = ["category_id","posts_id"];

}

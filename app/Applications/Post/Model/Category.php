<?php

namespace App\Applications\Post\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=  [
        'id',
        'title',
        'slug'
    ];

    public function article()
    {
        return $this->belongsToMany(Posts::class,'category_post');
    }

}
?>

<?php

namespace App\Applications\Post\Model;

use App\Applications\User\Model\User;
use Illuminate\Database\Eloquent\Model;


class Posts extends Model
{


    protected $fillable = [
        'id',
        'title',
        'body',
        'user_id',
        'creator', 
        'image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function category(){
        return $this->belongsToMany(Category::class, 'category_post');
    }

}
?>

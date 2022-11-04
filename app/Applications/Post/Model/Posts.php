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

<<<<<<< HEAD
=======
    protected $with = [
        'categories'
    ];

>>>>>>> dad9f59c2aa589aa8959f41aa87596aadba6bcc3
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_post');
    }

}
?>

<?php

namespace App\Applications\Post\Model;

use App\Applications\User\Model\User;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{

    protected $table='posts';

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

}
?>

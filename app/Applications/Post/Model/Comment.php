<?php

namespace App\Applications\Post\Model;

use App\Applications\User\Model\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table='comments';

    protected $fillable=[
        'comment',
        'user_id',
        'posts_id'
    ];

    public function author(){
        return $this->belongsTo(User::class);
    }

    public function article(){
        return $this->belongsTo(Posts::class);
    }
}
?>

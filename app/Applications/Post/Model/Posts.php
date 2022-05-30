<?php

namespace App\Applications\Post\Model;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = [
        'id',
        'title',
        'body',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(USer::class, 'id');
    }

}
?>
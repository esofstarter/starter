<?php

namespace App\Applications\Post\Model;

use App\Applications\User\Model\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;



class Posts extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'id',
        'title',
        'body',
        'user_id',
        'creator', 
        'image'
    ];

    protected $with = [
        'categories',
        'media'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('post_image')
            ->singleFile();
    }

}
?>

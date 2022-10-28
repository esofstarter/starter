<?php

namespace App\Applications\Post\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='categories';

    public function article()
    {
        return $this->hasMany(Posts::class);
    }

}
?>
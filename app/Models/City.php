<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function posts()
    {
        // cityは複数のポストを持つ
        return $this->hasMany(Post::class);
    }
}

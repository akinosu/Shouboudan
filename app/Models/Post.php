<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // 割り当て許可
    protected $fillable = [
        'subject',
        'message',
        'city_id',
        'image',
        'gender',
        'age',
        'immigrant',
        'start',
        'end',
        'user_id',
     ];
     
    public function Comments()
    {
        // 投稿はたくさんのコメントを持つ
        return $this->hasMany(Comment::class);
    }

    public function City()
    {
        // 投稿は1つのcityに属する
        return $this->belongsTo(City::class);
    }

    public function User()
    {
        // 1つの投稿は1つのuserに属する
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        // 投稿はたくさんのfavoriteを持つ
        return $this->hasMany(Favorite::class);
    }

    public function nices()
    {
        return $this->hasMany(Nice::class);
    }

    //任意の市区町村を含むものとするローカルスコープ
    public function scopeCityAt($query, $city_id)
    {
        if (empty($city_id)) {
            return;
        }
          
        return $query->where('city_id', $city_id);
    }
   
    //「名前・本文」検索スコープ
    public function scopeFuzzyNameMessage($query, $searchword)
    {
        if (empty($searchword)) {
            return;
        }
      
        return Post::whereHas('user', function ($query) use ($searchword) {
            $query
               ->Where('name', 'like', "%{$searchword}%")
               ->orWhere('message', 'like', "%{$searchword}%");
        });
    }
}

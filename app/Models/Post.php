<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // 割り当て許可
    protected $fillable = [
        'name',
        'subject',
        'message',
        'city_id',
        'image',
        'user_id',
        'gender',
        'age',
        'immigrant',
        'start',
        'end',
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

    public function nices() {
        return $this->hasMany(Nice::class);
    }

    public function getPostCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }

    public function getUserPost(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }

  //任意の市区町村を含むものとする（ローカル）スコープ
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

        return $this->whereHas('user', function ($query) use($searchword) {
            $query->Where('name', 'like', "%{$searchword}%")
            ->orWhere('message', 'like', "%{$searchword}%");
        });
        
    }

    public function getPostSearchCity($city_id, $pref_id) {

         // 市区町村絞り込みのcity_idをもっていたら当該city_idのみのpostを返す
         if (is_null($city_id)) {
            // 選択した都道府県に所属している投稿を取得　リレーション先Cityのpref_id=$pref_idに所属するPostテーブルデータのみ取得。
            return $this->whereHas('city', function ($query) use ($pref_id) {
                $query->where('pref_id', $pref_id);
            })->paginate(10);

        // $city_name = null;
        } else {
            return $this->whereHas('city', function ($query) use ($city_id) {
                $query->where('city_id', $city_id);
            })->paginate(10);
        }
    }

    public function getPostSearchword($city_id, $searchword) {
        // 検索一覧取得
        return $this->with(['comments', 'city'])
            ->orderBy('posts.created_at', 'desc') //usersテーブルをjoinしているため、created_atの前に明示的にpostsテーブルのものだと書く。
            ->cityAt($city_id)
            ->fuzzyNameMessage($searchword)
            ->paginate(10);
        
    }
}

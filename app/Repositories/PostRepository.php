<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Exception;

class PostRepository implements PostRepositoryInterface
{
    // 検索処理
    public function getPostSearchword($city_id, $searchword)
    {
        // 検索一覧取得
        return Post::with(['comments', 'city'])
            ->orderBy('posts.created_at', 'desc') //usersテーブルをjoinしているため、created_atの前に明示的にpostsテーブルのものだと書く。
            ->cityAt($city_id)
            ->fuzzyNameMessage($searchword)
            ->paginate(10);
    }
    
    // 市区町村名からの投稿絞り込み
    public function getPostSearchCity($city_id, $pref_id)
    {
        // 市区町村絞り込みのcity_idをもっていたら当該city_idのみのpostを返す
        if (is_null($city_id)) {
            // 選択した都道府県に所属している投稿を取得　リレーション先Cityのpref_id=$pref_idに所属するPostテーブルデータのみ取得。
            return Post::whereHas('city', function ($query) use ($pref_id) {
                $query->where('pref_id', $pref_id);
            })->paginate(10);
        } else {
            return Post::whereHas('city', function ($query) use ($city_id) {
                $query->where('city_id', $city_id);
            })->paginate(10);
        }
    }

    //post_idで投稿絞り込み
    public function getPostSearchId($post_id)
    {
        return Post::findOrFail($post_id);
    }

    public function getPostCount($user_id)
    {
        return Post::where('user_id', $user_id)
        ->count();
    }

    public function getUserPost($user_id)
    {
        return Post::where('user_id', $user_id)
        ->orderBy('created_at', 'DESC')
        ->paginate(50);
    }

    public function PostDestroy($post, $user_post_id, $pref_id, $city_id)
    {
        DB::beginTransaction();
        try {
            $post->comments()->delete(); // コメント削除実行
            $post->delete();  // 投稿削除実行
            DB::commit();
            $result = 1;
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            echo "エラーが発生しました。";
            $result = 0;
        }
        return $result;
    }
}

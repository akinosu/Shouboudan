<?php

namespace App\Services;

use App\Repositories\PostRepositoryInterface;

class PostService
{
    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepositry = $postRepo;
    }
  
    //post_idで投稿絞り込み
    public function getPostSearchId($post_id)
    {
        return $this->postRepositry->getPostSearchId($post_id);
    }

    // 検索一覧取得 検索ワードが入力されている場合はそのpostを、
    // 市区町村絞り込みのcity_idをもっていたら該当city_idのみのpostを返す
    public function getPost($searchword, $city_id, $pref_id)
    {
        if ($searchword != null) {
            return $this->postRepositry->getPostSearchword($city_id, $searchword);
        } else {
            return $this->postRepositry->getPostSearchCity($city_id, $pref_id);
        }
    }

    public function getPostCount($user_id)
    {
        return $this->postRepositry->getPostCount($user_id);
    }

    public function getUserPost($user_id)
    {
        return $this->postRepositry->getUserPost($user_id);
    }

    public function PostDestroy($post, $user_post_id, $pref_id, $city_id)
    {
        return $this->postRepositry->PostDestroy($post, $user_post_id, $pref_id, $city_id);
    }
}

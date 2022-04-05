<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    public function getPostSearchword($city_id, $searchword);
    public function getPostSearchCity($city_id, $pref_id);
    public function getPostSearchId($post_id);
    public function getPostCount(Int $user_id);
    public function getUserPost(Int $user_id);
    public function PostDestroy($post, $user_post_id, $pref_id, $city_id);
}

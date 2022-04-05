<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    public function getTweet($search_pref, $pref_name)
    {
        // Twitter OAuth認証
        $connection = new TwitterOAuth(
            config('twitter.TWITTER_CLIENT_KEY'),
            config('twitter.TWITTER_CLIENT_SECRET'),
            config('twitter.TWITTER_CLIENT_ID_ACCESS_TOKEN'),
            config('twitter.TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET')
        );
        
        $connection->setApiVersion('2');
        $content = $connection->get("account/verify_credentials");
        $query = '('.$search_pref.' OR '.'#'.$search_pref.' OR '.'#'.$pref_name->pref_name.') (消防団 OR #消防団)- is:retweet';
        return $connection->get('tweets/search/recent', ['query'=>$query,'expansions'=>'author_id']);
    }
}

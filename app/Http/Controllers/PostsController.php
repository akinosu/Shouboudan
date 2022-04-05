<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwitterService;
use App\Services\PostService;
use App\Services\NiceService;
use App\Services\CityService;
use App\Services\ImageResizeService;
use App\Models\User;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function __construct(TwitterService $twitterService, PostService $postService, NiceService $niceService, CityService $cityService, ImageResizeService $imageService)
    {
        $this->twitterService = $twitterService;
        $this->postService = $postService;
        $this->niceService = $niceService;
        $this->cityService = $cityService;
        $this->imageService = $imageService;
    }

    public function index(User $user, Request $request)
    {
        // ルートパラメータより取得
        $pref_id = $request->pref_id;
        $city_id = $request->city_id;
        $searchword = $request->searchword;

        $posts = $this->postService->getPost($searchword, $city_id, $pref_id);
        $city_name = $this->cityService->getCityName($city_id);
        $pref_name = $this->cityService->getPrefName($pref_id);
        $cities = $this->cityService->getCity($pref_id);
        $nices = $this->niceService->getNiceSearchIP($request);
        $search_pref = substr($pref_name->pref_name, 0, -3); //末尾の「都・道・府・県」をのぞいた文字列
        $tweets = $this->twitterService->getTweet($search_pref, $pref_name);

        return view('bbs.post', [
            'posts'     => $posts,
            'pref_id'   => $pref_id,
            'city_id'   => $city_id,
            'cities'    => $cities,
            'pref_name' => $pref_name,
            'city_name' => $city_name,
            'tweets'    => $tweets,
            'nices'     => $nices,
            'user'      => $user,
            'searchword' => $searchword,
        ]);
    }

    public function show(Request $request)
    {
        $searchword = $request->searchword;
        $user_post_id = $request->user_post_id;
        // ルートパラメータより取得
        $post_id = $request->post_id;
        $pref_id = $request->pref_id;
        $city_id = $request->city_id;

        $nices = $this->niceService->getNiceSearchIP($request);
        $post = $this->postService->getPostSearchId($post_id);

        return view('bbs.show', [
            'post' => $post,
            'pref_id' => $pref_id,
            'city_id' => $city_id,
            'nices' => $nices,
            'searchword' => $searchword,
            'user_post_id' => $user_post_id,
        ]);
    }

    public function create(Request $request)
    {
        // ルートパラメータより取得
        $pref_id = $request->pref_id;
        $city_id = $request->city_id;
        
        // ログイン済みのときの処理
        // city_nameは新規作成時に市区町村を選択していた場合に初期値として使用
        $cities = $this->cityService->getCityAddSelect($pref_id);
        $city_name = $this->cityService->getCityName($city_id);

        return view('bbs.create', [
            'cities' => $cities,
            'pref_id' => $pref_id,
            'city_id' => $city_id,
            'city_name' => $city_name
        ]);
    }

    public function store(PostRequest $request, Post $post)
    {
        DB::beginTransaction();
        try {
            // リクエストボディから、imgpath以外を取得
            $savedata = $request->except(['imgpath']);
            $img = $request->imgpath;
    
            //画像リサイズ
            // 添付画像ある場合のみ処理
            if ($img != null) {
                $img = $this->imageService->imageResize($img, $request);
                $savedata['image'] = $img;
            }
    
            $post->fill($savedata)->save();
            DB::commit();
            $pref_id = $this->cityService->getPrefId($savedata['city_id']);

            return redirect()->route('pref_id.index', [
            'pref_id' => $pref_id,
            'city_id' => $savedata['city_id']
            ])
            ->with('poststatus', '新規投稿しました');
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return;
        }
    }

    public function destroy(Request $request)
    {
        try {
            $city_id = $request->city_id;
            $user_post_id = $request->user_post_id;
            // ルートパラメータより取得
            $pref_id = $request->pref_id;
            $post_id = $request->post_id;

            $post = $this->postService->getPostSearchId($post_id);
            $result = $this->postService->PostDestroy($post, $user_post_id, $pref_id, $city_id);

            if ($result == 1) {
                $mes = '投稿を削除しました';
            } else {
                $mes = '投稿の削除に失敗しました';
            }

            // マイページを見ていた場合はマイページの投稿一覧に返す
            if ($user_post_id != null) {
                return redirect()->route('users.show', [
                'user_post_id' => $user_post_id,
                'user' => auth()->user()->id
                ])
                ->with('poststatus', $mes);
            } else {
                return redirect()->route('pref_id.index', [
                'pref_id' => $pref_id,
                'city_id' => $city_id])
                ->with('poststatus', $mes);
            }
        } catch (Exception $e) {
            report($e);
            echo "エラーが発生しました。";
        }
    }
}

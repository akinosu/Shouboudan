<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Services\TwitterService;
use App\Models\User;
use App\Models\Post;
use App\Models\City;
use App\Models\Nice;
use App\Http\Requests\PostRequest;
use Controllers\Auth;
use Abraham\TwitterOAuth\TwitterOAuth;

class PostsController extends Controller
{
   
    public function index(Post $post, User $user, TwitterService $twitter, Request $request)
    {
        $pref_id = $request->pref_id;
        $city_id = $request->city_id;
        $searchword = $request->searchword;
        $ip = $request->ip();
        $nices = Nice::where('ip', $ip)->get();
        $pref_name = City::where('pref_id', $pref_id)->select('pref_name')->first();
        $search_pref = substr($pref_name->pref_name,0,-3); //末尾の「都・道・府・県」をのぞいた文字列
        $cities = City::where('pref_id', $pref_id)->get(); // 選択した都道府県に所属している市区町村情報を取得
        $tweets = $twitter->getTweet($search_pref,$pref_name);
        $city_name = City::where('id', $city_id)->select('city_name')->first();

         // 検索一覧取得 検索ワードが入力されている場合はそのpostを、
         // 市区町村絞り込みのcity_idをもっていたら当該city_idのみのpostを返す
         if ($searchword != null) {
            $posts = $post->getPostSearchword($city_id, $searchword);
            }else {
                $posts = $post->getPostSearchCity($city_id, $pref_id);
            }

        
        return view('bbs.post1', [  'posts'     => $posts,
                                    'pref_id'   => $pref_id,
                                    'city_id'   => $city_id,
                                    'cities'    => $cities,
                                    'pref_name' => $pref_name,
                                    'city_name' => $city_name,
                                    'tweets'    => $tweets,
                                    'nices'     => $nices,
                                    'user'      => $user,
                                    'searchword'=> $searchword,
                                ]);
    }


    public function show(Request $request)
    {
        $post_id = $request->post_id;
        $pref_id = $request->pref_id;
        $city_id = $request->city_id;
        $searchword = $request->searchword;
        $ip = $request->ip();
        $nices = Nice::where('ip', $ip)->get();
        $post = Post::findOrFail($post_id);
        $user_post_id = $request->user_post_id;

        return view('bbs.show1', [
        'post' => $post,
        'pref_id' => $pref_id,
        'city_id' => $city_id,
        'nices' => $nices,
        'searchword'=> $searchword,
        'user_post_id' => $user_post_id,
    ]);
    }

    /**
 * 投稿フォーム
 */
    public function create(Request $request)
    {
       
        // ログイン済みのときの処理
        // city_nameは新規作成時に市区町村を選択していた場合に初期値として使用
        $pref_id = $request->pref_id;
        $city_id = $request->city_id;
        $cities = City::where('pref_id', $pref_id)->pluck('city_name', 'id')->prepend('選択', '');
        $city_name = City::where('id', $city_id)->select('city_name')->first();
        // dd($city_name);
        return view('bbs.create', ['cities' => $cities,'pref_id'=>$pref_id,'city_id'=>$city_id,'city_name'=>$city_name]);
           
    }
 
 
    /**
     * バリデーション、登録データの整形など
     */
    public function store(PostRequest $request)
    {
        $img = $request->imgpath;

        // 添付画像ある場合のみ処理
        if($img != null){
            $filename = $request->imgpath->getClientOriginalName();
            $img = $request->imgpath->storeAs('image', $filename, 'public');

            // 画像リサイズ処理
            // 画像を読み込む
            $image = \Image::make('storage/'.$img);
            // リサイズする
            $image->resize(
                600,
                null,
                function ($constraint) {
                    // 縦横比を保持したままにする
                    $constraint->aspectRatio();
                    // 小さい画像は大きくしない
                    $constraint->upsize();
                }
            );
            $image->save(storage_path('app/public/'.$img));
        }

        $savedata = [
        'subject' => $request->subject,
        'message' => $request->message,
        'city_id' => $request->city_id,
        'image' => $img,
        'gender' => $request->gender,
        'age' => $request->age,
        'immigrant' => $request->immigrant,
        'start' => $request->start,
        'end' => $request->end,
        'user_id' => $request->user_id,
    ];
 
        $pref_id = City::where('id', $savedata['city_id'])->pluck('pref_id')->first();
        // dd($savedata['img']);
        $post = new Post;
        // dd($post);
        $post->fill($savedata)->save();
        
        return redirect()->route('{pref_id?}.index', ['pref_id'=>$pref_id,'city_id' =>$savedata['city_id']])->with('poststatus', '新規投稿しました');
    }

    /**
    * 物理削除
    */
    public function destroy(Request $request)
    {
        
            $pref_id = $request->pref_id;
            $post_id = $request->post_id;
            $city_id = $request->city_id;
            $post = Post::findOrFail($post_id);
    
            $post->comments()->delete(); // ←★コメント削除実行
            $post->delete();  // ←★投稿削除実行
            
            return redirect()->route('{pref_id?}.index', ['pref_id'=>$pref_id,'city_id'=>$city_id])->with('poststatus', '投稿を削除しました');
       
    }
}

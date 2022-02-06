<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\City;
 
class CommentsController extends Controller
{
    /**
     * バリデーション、登録データの整形など
     */
    public function store(CommentRequest $request)
    {
        $savedata = [
            'post_id' => $request->post_id,
            'name' => $request->name,
            'comment' => $request->comment,
        ];

        $city_id = $request->city_id;
        $pref_id = $request->pref_id;
        $comment = new Comment;
        $comment->fill($savedata)->save();

        return redirect()->route('show', ['post_id'=>$savedata['post_id'],'pref_id'=>$pref_id,'city_id'=>$city_id])->with('commentstatus', '新規投稿しました');
    }
}

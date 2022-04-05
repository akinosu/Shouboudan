<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function store($request)
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

        return redirect()->route('pref_id.show', ['post_id'=>$savedata['post_id'],'pref_id'=>$pref_id,'city_id'=>$city_id])->with('commentstatus', '新規投稿しました');
    }
}

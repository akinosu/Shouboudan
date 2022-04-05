<?php

namespace App\Repositories;

use App\Models\Nice;
use App\Models\Post;
use Exception ;
use Illuminate\Support\Facades\DB;

class NiceRepository implements NiceRepositoryInterface
{
    public function __construct()
    {
        $this->nice = new Nice;
    }

    public function nice($request)
    {
        $post_id = $request->post_id;
        DB::beginTransaction();
        try {
            $this->nice->post_id = $post_id;
            $this->nice->ip = $request->ip();
            $this->nice->user_id = Post::where('id', $post_id)->pluck('user_id')->first();
            $this->nice->save();
            DB::commit();
            return back()->with('poststatus', 'いいね！しました');
        } catch (Exception $e) {
            report($e);
            DB::rollback();
            return back()->with('poststatus', 'いいね！に失敗しました');
        }
    }

    public function unnice($request)
    {
        DB::beginTransaction();
        try {
            $post_id = $request->post_id;
            $user = $request->ip();
            $nice = Nice::where('post_id', $post_id)->where('ip', $user)->first();
            $nice->delete();
            DB::commit();
            return back()->with('poststatus', 'いいね！を取り消しました');
        } catch (Exception $e) {
            report($e);
            DB::rollback();
            return back()->with('poststatus', 'いいね！の取り消しに失敗しました');
        }
    }

    public function getNiceSearchIP($ip)
    {
        return Nice::where('ip', $ip)
        ->get();
    }

    public function getUserNices($user_id)
    {
        return Nice::where('user_id', $user_id)
        ->orderBy('created_at', 'DESC')
        ->paginate(50);
    }
}

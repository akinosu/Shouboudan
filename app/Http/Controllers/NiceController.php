<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Nice;
use Illuminate\Support\Facades\Auth;

class NiceController extends Controller
{
    //
    public function nice(Request $request, Post $post){
        $post_id = $request->post_id;
        $nice = New Nice();
        $nice->post_id = $post_id;
        $nice->ip = $request->ip();
        // $user_id = Auth::user()->id;
 
        // if(Auth::check()){
        //     $nice->user_id = Auth::user()->id;
        // }

        $nice->user_id = Post::where('id',$post_id)->pluck('user_id')->first();
 
        $nice->save();
        return back();
    }

    public function unnice(Request $request){
        $post_id = $request->post_id;
        $user = $request->ip();
        $nice = Nice::where('post_id', $post_id)->where('ip', $user)->first();
        $nice->delete();
        return back();
    }
}

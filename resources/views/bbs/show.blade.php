@extends('layouts.bbslayout')
 
@section('title', '投稿の詳細ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿詳細ページの説明文')
@section('pageCss')
@endsection
 
@include('layouts.bbsheader')
 
@section('content')

<div class="container mt-4">
    <div class="mt-4 mb-4">
        <!-- 戻るボタン -->
        <a href="{{ route('{pref_id?}.index', ['pref_id'=>$pref_id,'city_id'=>$city_id])}}" class="btn btn-primary">
            一覧に戻る
        </a>

    <!-- コメント投稿完了時のフラッシュメッセージ表示部 -->
    @if (session('commentstatus'))
    <div class="alert alert-success mt-4 mb-4">
     {{ session('commentstatus') }}
    </div>
    @endif

        <!-- 投稿削除ボタン
            ユーザー名と投稿者が一致しなければ削除ボタンは表示されない -->
        @if (Auth::check())
            @if (Auth::user()->name == $post->name) 
                <form action="{{route('destroy', ['pref_id'=>$pref_id,'post_id'=>$post->id ,'city_id'=>$city_id])}}" method="post" class="float-right">
                        @csrf
                        @method('delete')
                        <input type="submit" value="投稿を削除する" class="btn btn-danger" onclick='return confirm("削除しますか？\nコメントも全て削除されます。");'>
                </form>
            @else 
                <!-- ログインしていないときは何も表示しない -->

            @endif
        @endif
    </div>
    
    <div class="border p-4">
        <!-- 件名 -->
        <h1 class="h4 mb-4">
            {{ $post->subject }}
        </h1>

        <!-- いいねボタン -->
        <div class="d-flex align-items-center">
                <!-- $nice(既にipで抽出済)を$post_idのみ抽出し配列にし、$post->idの値がその中にあるかどうかの真偽式 -->
            @if (!in_array($post->id, array_column($nices->toArray(), 'post_id'), TRUE))
                <a class="far fa-heart fa-fw fa-lg" style="text-decoration: none;" href="{{ url('pref/'.$pref_id.'/nice/'.$post->id) }}" class="mb-0"></a>
            @else
                <a class="fas fa-heart fa-fw fa-lg" style="text-decoration: none;" href="{{ url('pref/'.$pref_id.'/unnice/'.$post->id) }}" class="mb-0"></a>
            @endif
            <p class="mb-0 text-secondary">{{ count($post->nices) }}</p>
            <p class="mb-0 ">いいね！</p>
        </div>
 
        <!-- 投稿情報 -->
        <div class="summary">
            <p><span>{{ $post->name }}</span> / <time>{{ $post->updated_at->format('Y.m.d H:i') }}</time> / {{ $post->city->name }} / {{ $post->id }}</p>
        </div>
 
        <!-- 本文 -->
        <p class="mb-5">
            {!! nl2br(e($post->message)) !!}
        </p>
 
        <!-- 画像 -->
        @if ($post->img != null)
            <h2 class="h5 mb-4" style="margin-top:20px;">
                添付画像
            </h2>
             <div class="img">
                <img src=" {{ asset('storage/'.$post->img)}}">
             </div>
        @endif

        <section>
            <h2 class="h5 mb-4">
                コメント
            </h2>
 
            @forelse($post->comments as $comment)
                <div class="border-top p-4">
                    <time class="text-secondary">
                        {{ $comment->name }} / 
                        {{ $comment->created_at->format('Y.m.d H:i') }} / 
                        {{ $comment->id }}
                    </time>
                    <p class="mt-2">
                        {!! nl2br(e($comment->comment)) !!}
                    </p>
                </div>
            @empty
                <p>コメントはまだありません。</p>
            @endforelse
        </section>
        </div>

     <h2 class="h5 mb-4" id="h2_comments_post">コメント投稿</h2>

    <form class="mb-4" method="POST" action="{{ route('comment.store') }}">
    @csrf
 
    <input name="post_id" type="hidden" value="{{ $post->id }}">
    <input name="city_id" type="hidden" value="{{ $post->city_id }}">
    <input name="pref_id" type="hidden" value="{{ $post->city->pref_id }}">

    <div class="form-group">
        <label for="subject">名前</label>
 
        <input id="name" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
            value="{{ old('name') }}"
            type="text">
        @if ($errors->has('name'))
         <div class="invalid-feedback">
         {{ $errors->first('name') }}
         </div>
        @endif
    </div>
 
    <div class="form-group">
     <label for="body">
     本文
     </label>
 
        <textarea
            id="comment"
            name="comment"
            class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}"
            rows="4"
        >{{ old('comment') }}</textarea>
        @if ($errors->has('comment'))
         <div class="invalid-feedback">
         {{ $errors->first('comment') }}
         </div>
        @endif
    </div>
 
    <div class="mt-4">
     <button type="submit" class="btn btn-primary">
     コメントする
     </button>
    </div>
    </form>
 
</div>

@endsection
 
@include('layouts.bbsfooter')
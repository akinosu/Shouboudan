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
        <!-- user_post_idはマイページを見ていた場合にもっている変数 -->
        @if ($user_post_id != null)
        <a href="{{url('users/' .auth()->user()->id)}}" class="btn btn-primary">
            @else
            <a href="{{ route('pref_id.index', ['pref_id'=>$pref_id,'city_id'=>$city_id,'searchword'=> $searchword,])}}"
                class="btn btn-primary">
                @endif
                一覧に戻る
            </a>

            <!-- コメント投稿完了時のフラッシュメッセージ表示部 -->
            @if (session('commentstatus'))
            <div class="alert alert-success mt-4 mb-4">
                {{ session('commentstatus') }}
            </div>
            @endif

            <!-- 投稿削除ボタン
            ユーザーIDと投稿者が一致しなければ削除ボタンは表示されない -->
            @if (Auth::check())
            @if (Auth::user()->id == $post->user_id)
            <form
                action="{{route('destroy', ['pref_id'=>$pref_id,'post_id'=>$post->id ,'city_id'=>$city_id, 'user_post_id'=>$user_post_id])}}"
                method="post" class="float-right">
                @csrf
                @method('delete')
                <input type="submit" value="投稿を削除する" class="btn btn-danger"
                    onclick='return confirm("削除しますか？\nコメントも全て削除されます。");'>
            </form>
            @else
            <!-- ログインしていないときは何も表示しない -->

            @endif
            @endif
    </div>


    <div class="card  mb-3">
        <div class="card-haeder p-3 w-100 d-flex flex-wrap">
            <div class="d-flex flex-grow-1">
                @if (isset($post->user->profile_image))
                <img src="{{ asset('storage/profile_image/' .$post->user->profile_image) }}" class="rounded-circle"
                    width="50" height="50">
                @else
                <img src="{{ asset('storage/profile_image/20200501_noimage.png') }}" class="rounded-circle" width="50"
                    height="50">
                @endif

                <div class="ml-2 d-flex flex-column flex-grow-1">
                    <p class="mb-0 text-nowrap"><a
                            href="{{ route('pref_id.index', ['pref_id'=>$post->city->pref_id]) }}" class="mb-0">{{
                            $post->city->pref_name }}</a>
                        /<a href="{{ route('pref_id.index', ['city_id'=>$post->city->id,'pref_id'=>$post->city->pref_id]) }}"
                            class="mb-0">{{ $post->city->city_name }}</a>のクチコミ</p>
                    <div class="d-flex flex-grow-1">
                        <a href="{{url('users/' .$post->user_id)}}" class="mb-0 text-nowrap">{{ $post->user->name }}</a>
                        <p class="mb-0 text-secondary text-nowrap">
                            （
                            @if ($post->gender != null)
                            @if ($post->gender === 1)
                            男性
                            @elseif ($post->gender === 2)
                            女性
                            @endif
                            ・
                            @endif
                        </p>
                        <p class="mb-0 text-secondary text-nowrap">
                            {{$post->age}}歳
                            ）
                        </p>
                    </div>
                </div>
            </div>
            <div class="ml-5 d-flex flex-column flex-grow-1">
                <p class="mb-0 text-secondary text-nowrap mb-1">
                    <span class="text-white bg-primary title-label">居住期間</span>
                    @if ($post->end != null)
                    @if ($post->start != null)
                    {{$post->start}}年
                    <span>~</span>
                    {{$post->end}}年
                    @else
                    <span>~</span>
                    {{$post->end}}年
                    @endif
                    @elseif ($post->start != null)
                    {{$post->start}}年
                    <span>~</span>
                    @else
                    不明
                    @endif

                <p class="mb-0 text-secondary text-nowrap">
                    <span class="text-white bg-primary title-label">地域との関係</span>
                    @if ($post->immigrant === 0)
                    出身者
                    @else
                    移住者
                    @endif
                </p>

            </div>
        </div>
        <div class="card-body">
            <h4><a class="card-title">{{ $post->subject }}</a></h4>
            <div>{!! nl2br(e($post->message)) !!}</div>
            @if ($post->image!= null)
            <div><img src="{{ asset('storage/'.$post->image)}}" width="300px"></div>
            @endif
        </div>
        <div class="card-footer py-1 d-flex justify-content-end bg-white mt-1 mb-1">
            <div class="d-flex justify-content-start flex-grow-1">
                <p class="mb-0 mr-3 text-secondary">ID:{{ $post->id }}</p>
            </div>
            <div class="d-flex justify-content-start flex-grow-1">
                <p class="mb-0 text-secondary">投稿日時:{{ $post->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="d-flex align-items-center">
                <!-- $nice(既にipで抽出済)を$post_idのみ抽出し配列にし、$post->idの値がその中にあるかどうかの真偽式 -->
                @if (!in_array($post->id, array_column($nices->toArray(), 'post_id'), TRUE))
                <a class="far fa-heart fa-fw fa-lg text-decoration-none"
                    href="{{ route('nice', ['post_id'=>$post->id]) }}"></a>
                @else
                <a class="fas fa-heart fa-fw fa-lg text-decoration-none"
                    href="{{ route('unnice', ['post_id'=>$post->id]) }}"></a>
                @endif
                <p class="mb-0 text-secondary">{{ count($post->nices) }}</p>
            </div>
        </div>
    </div>

    <div class="card  mb-3">
        <section>
            <div class="card-body" id="comment">
                <h4 class="card-title">コメント</h4>

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
            </div>
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
                value="{{ old('name') }}" type="text">
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
            <textarea id="comment" name="comment" class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}"
                rows="4">{{ old('comment') }}</textarea>
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
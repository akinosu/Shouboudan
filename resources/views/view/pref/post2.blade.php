@extends('layouts.base')
 
@section('title', 'LaravelPjt BBS 投稿の一覧ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿一覧ページの説明文')
@section('pageCss')
<link href="/css/bbs/sticky-footer.css" rel="stylesheet">
@endsection
 
@include('layouts.bbsheader')
 
@section('content')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr style="white-space: nowrap;">
            <th>市区町村</th>
            <th>タイトル</th>
            <th>内容</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="tbl">
        @foreach ($posts as $post)
            <tr>
                <td style="white-space: nowrap;">{{ $post->city->city_name }}</td>
                <td>{{ $post->subject }}</td>
                <td>{!! nl2br(e(Str::limit($post->message, 65))) !!}
                <p style="margin-bottom:0;">
                    @if ($post->comments->count() >= 1)
                        <span class="badge badge-danger">コメント：{{ $post->comments->count() }}件</span>  
                    @endif
                    @if ($post->img != null)
                    <span class="badge badge-info">画像あり</span>
                    @endif
                </p>
                <div style="display:flex; justify-content:right; color:grey; font-size:90%;">
                    <div style="white-space: nowrap;">投稿日時:{{ $post->created_at->format('Y.m.d') }}</div>
                    <div style="margin-left:20px; white-space: nowrap;">投稿者:{{ $post->name }}</div>
                    <div style="margin-left:20px; white-space: nowrap;">ID:{{ $post->id }}</div>
                </div>
                </td>
                <td class="text-nowrap" style="vertical-align:center;">
                    <p style=""><a href="{{ action('PostsController@show' ,['post_id'=>$post->id, 'pref_id'=>$pref_id, 'city_id'=>$city_id]) }}" class="btn btn-primary btn-sm">詳細を見る</a></p> 
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
 
@include('layouts.bbsfooter')
@extends('layouts.bbslayout')
 
@section('title', 'LaravelPjt BBS 投稿の一覧ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿一覧ページの説明文')
@section('pageCss')
<link href="/css/bbs/sticky-footer.css" rel="stylesheet">
<!-- twitterスニペット -->
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>
@endsection
 
@include('layouts.bbsheader')
 
@section('content')
<div class="container">
            <!-- pref_nameをセッションに保存 -->
            @if (is_null($pref_name))
                <!-- {{$pref_name = session()->get('str')}} -->
            @endif
            <!-- {{session()->put('str', $pref_name)}} -->
            
            <!-- @if(isset($city_name))
                <div><p id="titel_pref">{{$city_name->city_name}}の消防団</p></div>
            @endif
            {{--@php $post->city->pref_name??'' @endphp --}} -->


        <div class="flex-wrapper">     
            <div class="mt-4 mb-4"><h3><a style="color: black;" id="titel_pref" href="{{route('index', ['pref_id'=>$pref_id])}}">{{$pref_name->pref_name}}の消防団</a></h3></div>
            <div class="mt-4 mb-4">
                <a href="{{ route('map.index')}}" class="btn btn-danger">
                    全国マップに戻る
                </a>
            </div>
        </div>

        <div class="accordion" id="accordion-4">
            <div class="card">
                <div class="card-header" id="header-4a">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#card-4a" aria-expanded="true" aria-controls="card-4a">
                        市区町村を選択する <i class="fas fa-chevron-circle-down"></i>
                    </button>
                </div>
                <div id="card-4a" class="collapse" aria-labelledby="header-4a" data-parent="#accordion-4">
                    <div class="card-body">
                        @foreach($cities as $city)
                        <span class="btn"><a href="{{ route('index', ['city_id'=>$city->id,'pref_id'=>$city->pref_id]) }}" title="{{ $city->city_name }}">{{ $city->city_name}}</a></span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
</div>
    <header class="navbar" style="background-color:#3490dc; margin-top:20px;">
        <div class="container">
            <div class="navbar-brand" style="color:white;"}}">
            @if(isset($city_name))
                {{$city_name->city_name}}のクチコミ一覧</>
                @elseクチコミ一覧
                @endif
            </div>
    </header>

<!-- 絞り込んだcityのクチコミ投稿数の表示 -->
    
<div class="container-fluid">
    <div class="mt-4 mb-4">
        <p>{{ $posts->total() }}件が見つかりました。</p>
    </div>

    <!--  新規投稿処理  -->
    <div class="mt-4 mb-4">
        <a href="{{ route('create',['pref_id'=>$city->pref_id,'city_id'=>$city_id]) }}" class="btn btn-primary">
            投稿の新規作成
        </a>
    </div>

    <!-- 新規投稿処理に成功した場合に表示 -->
    @if (session('poststatus'))
        <div class="alert alert-success mt-4 mb-4">
            {{ session('poststatus') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
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
                            <p style="margin-top:5px;">
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
                <div class="d-flex justify-content-center mb-5">
                {{ $posts->links() }}
                </div>
            </div>
        </div>

        <!-- 該当都道府県に関するtweetを表示　twitterAPIで取得したデータからtweetIDを取り出し、URLに渡す -->
        <div class="col-md-4">
            <p>{{$pref_name->pref_name}}の消防団に関するつぶやき（10件/直近7日）</p>
            <div style="max-height: 900px; max-width:100%; overflow: scroll; background-color: white;">
              {{--  @foreach ($tweets->data as $tweet)
                <blockquote class="twitter-tweet">
                <a class="twitter-timeline" href="https://twitter.com/_/status/{{$tweet->id}}">
                </blockquote>
                @endforeach --}}
            </div>
        </div>
    </div>
</div>

@endsection
 
@include('layouts.bbsfooter')
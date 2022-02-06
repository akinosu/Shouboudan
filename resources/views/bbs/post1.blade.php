@extends('layouts.bbslayout')
 
@section('title', '投稿一覧ページ')
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
<div class="container-fluid">
            <!-- pref_nameをセッションに保存 -->
            @if (is_null($pref_name))
                <!-- {{$pref_name = session()->get('str')}} -->
            @endif
            <!-- {{session()->put('str', $pref_name)}} -->
            
            <!-- @if(isset($city_name))
                <div><p id="titel_pref">{{$city_name->city_name}}の消防団</p></div>
            @endif
            {{--@php $post->city->pref_name??'' @endphp --}} -->


        <div class="flex-wrapper d-flex flex-wrap mt-5 mr-3 ml-3" style="justify-content:space-between;">     
            <div class=""><h3><a style="color: black;" id="titel_pref" href="{{route('{pref_id?}.index', ['pref_id'=>$pref_id])}}">{{$pref_name->pref_name}}の消防団</a></h3></div>
            <div class="">
                <a href="{{ route('map.index')}}" class="btn btn-danger ml-2">
                    全国マップに戻る
                </a>
            </div>
        </div>

        <div class="accordion mt-4" id="accordion-4">
            <div class="card">
                <div class="card-header" id="header-4a">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#card-4a" aria-expanded="true" aria-controls="card-4a">
                        市区町村を選択する <i class="fas fa-chevron-circle-down"></i>
                    </button>
                </div>
                <div id="card-4a" class="collapse" aria-labelledby="header-4a" data-parent="#accordion-4">
                    <div class="card-body">
                        @foreach($cities as $city)
                        <span class="btn"><a href="{{ route('{pref_id?}.index', ['city_id'=>$city->id,'pref_id'=>$city->pref_id]) }}" title="{{ $city->city_name }}">{{ $city->city_name}}</a>( {{($city->posts->count())}} )</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
</div>
    <header class="navbar mt-5" style="background-color:#3490dc; margin-top:20px;">
        <div class="container-fluid">
            <div class="navbar-brand" style="color:white;"}}">
            @if(isset($city_name))
                {{$city_name->city_name}}のクチコミ一覧</>
                @elseクチコミ一覧
                @endif
            </div>
    </header>

<!-- 絞り込んだcityのクチコミ投稿数の表示 -->
    
<div class="container-fluid">
    <div class="mt-4 d-flex flex-wrap" style="justify-content:space-between;">
        <div>
        <p>{{ $posts->total() }}件が見つかりました。</p>
        </div>
        <!-- 検索フォーム -->
        <div>
        <form class="form-inline" method="GET" action="{{ route('{pref_id?}.index',['pref_id'=>$pref_id]) }}">
            <div class="form-group mb-0">
                <input type="text" name="searchword" value="{{$searchword}}" class="form-control" placeholder="本文・投稿者を検索できます">
            </div>
            <input type="submit" value="検索" class="btn btn-info ml-2">
        </form>
        </div>
    </div>

    

    <!--  新規投稿処理  -->
    <div class="mb-4 mt-3">
        <a href="{{ route('{pref_id?}.create',['pref_id'=>$pref_id,'city_id'=>$city_id]) }}" class="btn btn-primary">
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
        @foreach ($posts as $post)
            <div class="card  mb-3">
                <div class="card-haeder p-3 w-100 d-flex flex-wrap">
                    <div class="d-flex flex-grow-1">
                        @if (isset($post->user->profile_image))
                        <img src="{{ asset('storage/profile_image/' .$post->user->profile_image) }}" class="rounded-circle" width="50" height="50">
                        @else
                        <img src="{{ asset('storage/profile_image/20200501_noimage.png') }}" class="rounded-circle" width="50" height="50">
                        @endif
    
                        <div class="ml-2 d-flex flex-column flex-grow-1">
                            <p class="mb-0 text-nowrap"><a href="{{ route('{pref_id?}.index', ['pref_id'=>$post->city->pref_id]) }}" class="mb-0">{{ $post->city->pref_name }}</a>
                            /<a href="{{ route('{pref_id?}.index', ['city_id'=>$post->city->id,'pref_id'=>$post->city->pref_id]) }}" class="mb-0">{{ $post->city->city_name }}</a>のクチコミ</p>
                            <div class="d-flex flex-grow-1">
                                <a href="{{url('users/' .$post->user_id)}}" class="mb-0 text-nowrap">{{ $post->user->name }}</a>
                                <p class="mb-0 text-secondary text-nowrap">
                                    （
                                    @if ($post->gender != null)
                                        @if ($post->gender === 1)
                                            男性
                                        @elseif ($post->gender === 2)
                                            女性
                                        @elseif ($post->gender === 3)
                                            どちらでもない
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
                    <div class="ml-5 d-flex flex-column flex-grow-1" >
                        <p class="mb-0 text-secondary text-nowrap mb-1">
                        <span class="text-white bg-primary" style="padding:1.5px;">居住期間</span>
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
                        <span class="text-white bg-primary" style="padding:1.5px;">地域との関係</span>
                            @if ($post->immigrant === 0)
                                出身者
                                @else
                                移住者
                            @endif
                        </p>
                    
                    </div>
                </div>
                <div class="card-body">
                    
                    <h5><a class="card-title" href="{{ route('show' ,['post_id'=>$post->id, 'pref_id'=>$pref_id,'city_id'=>$city_id,'searchword'=> $searchword]) }}">{{ $post->subject }}</a></h5>
                    <div class="d-flex" style="justify-content:space-between;">
                        <div>{!! nl2br(e(Str::limit($post->message, 150))) !!}</div>
                        @if ($post->img != null)
                        <div><img src="{{ asset('storage/'.$post->img)}}" width="100" height="100"></div>
                        @endif
                    </div>
                </div>
                <div class="card-footer py-1 d-flex justify-content-end bg-white flex-wrap">
                    <div class="d-flex justify-content-start flex-grow-1">
                        <p class="mb-0 text-secondary">ID:{{ $post->id }}</p>
                    </div>
                    <div class="d-flex justify-content-start flex-grow-1">
                    <p class="mb-0 text-secondary">投稿日時:{{ $post->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    @if ($post->image != null)
                    <div class="mr-3 d-flex align-items-center">
                        <a href=""><i class="far fa-image fa-fw fa-lg"></i></a>
                        <p class="mb-0 text-secondary">画像あり</p>
                    </div>
                    @endif
                    <div class="mr-3 d-flex align-items-center">
                    <a href="{{ route('show_comment' ,['post_id'=>$post->id, 'pref_id'=>$pref_id, 'city_id'=>$city_id,'searchword'=> $searchword, 'comment'=>'#comment']) }}"><i class="far fa-comment fa-fw fa-lg"></i></a>
                   {{-- <a href="{{ url('pref/'.$pref_id.'/show/'.$post->id.'/#comment' ) }}"><i class="far fa-comment fa-fw fa-lg"></i></a> --}}
                        <p class="mb-0 text-secondary">{{ count($post->comments) }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- $nice(既にipで抽出済)を$post_idのみ抽出し配列にし、$post->idの値がその中にあるかどうかの真偽式 -->
                    @if (!in_array($post->id, array_column($nices->toArray(), 'post_id'), TRUE))
                        <a class="far fa-heart fa-fw fa-lg" style="text-decoration: none;" href="{{ url('pref/'.$pref_id.'/nice/'.$post->id) }}" class="mb-0"></a>
                    @else
                        <a class="fas fa-heart fa-fw fa-lg" style="text-decoration: none;" href="{{ url('pref/'.$pref_id.'/unnice/'.$post->id) }}" class="mb-0"></a>
                    @endif
                    <p class="mb-0 text-secondary">{{ count($post->nices) }}</p>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- ページネーション -->
        <div class="d-flex justify-content-center">
        {{ $posts->links() }}
        </div>
    </div>
    

        <!-- 該当都道府県に関するtweetを表示　twitterAPIで取得したデータからtweetIDを取り出し、URLに渡す -->
        <div class="col-md-4">
            <p>{{$pref_name->pref_name}}の消防団に関する最近のつぶやき</p>
            <div style="max-height: 900px; max-width:90%; overflow: scroll; background-color: white;">
                @foreach ($tweets->data as $tweet)
                <blockquote class="twitter-tweet">
                <a class="twitter-timeline" href="https://twitter.com/_/status/{{$tweet->id}}">
                </blockquote>
                @endforeach 
            </div>
        </div>
    </div>


</div>

@endsection
 
@include('layouts.bbsfooter')
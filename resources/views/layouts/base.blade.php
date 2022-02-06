<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')｜magicmissile.info</title>
    <meta name="description" itemprop="description" content="@yield('description')">
    <meta name="keywords" itemprop="keywords" content="@yield('keywords')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/japanmap.css') }}" rel="stylesheet">
    <link href="/css/bbs/sticky-footer.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="styleSheet">
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
</head>
<body>
    <div id="app">
    @yield('header')

        <div class="container">
        <main class="py-4">
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

        <div id="js-contents-mainPanel" class="contents">
        </div>
    </main>
    </div>
    </div>

    <header class="navbar" style="background-color:#3490dc;">
    <div class="container">
        <div class="navbar-brand" style="color:white;"}}">
        @if(isset($city_name))
            {{$city_name->city_name}}のクチコミ一覧</>
            @elseクチコミ一覧
            @endif
        </div>
    </header>
    
<!-- 絞り込んだcityのクチコミ投稿数の表示 -->
    
    <div class="container">
    <div class="mt-4 mb-4">
        <p>{{ $posts->total() }}件が見つかりました。</p>
    </div>

    <!--  新規投稿処理  -->
    <div class="mt-4 mb-4">
    <a href="{{ route('create',['pref_id'=>$city->pref_id,'city_id'=>$city_id]) }}" class="btn btn-primary">
        投稿の新規作成
    </a>
    </div>
    </div>

<!-- 新規投稿処理に成功した場合に表示 -->
@if (session('poststatus'))
    <div class="alert alert-success mt-4 mb-4">
        {{ session('poststatus') }}
    </div>
@endif

<div class="container">
    @yield('content')
</div>
@yield('footer')

<div class="d-flex justify-content-center mb-5">
    {{ $posts->links() }}
</div>

</body>
</html>


<!-- <meta charset="UTF-8" />
<title>2段階選択式の日本地図</title>
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
$(function() {
    $.getJSON("/js/pref_city.json", function(data) {
        console.log(data);

        var param = window.location.href.slice(-2,-1);
        var param1 = param-1;
        var code = ('00'+param).slice(-2); // ゼロパディング
        console.log(param1);
        console.log(code);
        var pref_name = data[param1][code]["pref"]
        var city_kosu = data[param1][code]["city"].length;
        console.log(city_kosu);
        
        $('#pref_name').append(pref_name+'の消防団クチコミ');

        // alert(JSON.stringify(data[0]["01"]["city"][0]));
        for(var i=0; i<city_kosu; i++) {
        $('#select-pref').append('<option value="'+i+'">'+data[param1][code]["city"][i]["name"]+'</option>');
        }
    })
})
</script>

</head>
<body>
<div><h1 id="pref_name"></h1></div>

<select id="select-pref"><option value="">都道府県を選択してください</option></select>
<select id="select-city"><option value="">市区町村を選択してください</option></select>

<div id="js-contents-mainPanel" class="contents">

</div>
			
</body> -->

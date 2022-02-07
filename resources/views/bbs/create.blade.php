@extends('layouts.bbslayout')
 
@section('title', 'LaravelPjt BBS 投稿ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿ページの説明文')
@section('pageCss')
<link href="/css/bbs/style.css" rel="stylesheet">
@endsection
 
@include('layouts.bbsheader')
 
@section('content')
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h4 mb-4 font-weight-bold">
            投稿の新規作成
        </h1>
 
        <form method="POST" action="{{ route('{pref_id?}.store') }}" enctype="multipart/form-data">
            @csrf
 
            <fieldset class="mb-4">
 
            <!-- 名前はログイン情報からユーザー名を取得し、固定 -->
                <div class="form-group">
                    <label for="name">
                        名前
                    </label>
                    <p>
                        @if(Auth::user() != null)
                        {{Auth::user()->name}}
                        @else
                        ゲストユーザー"
                        @endif
                    </p>

                    <input
                        id="user_id"
                        name="user_id"
                        type="hidden"
                        class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}"
                        @if(Auth::user() != null)
                        value="{{Auth::user()->id}}"
                        @else
                        value="5"
                        @endif
                    >
                </div>

                <!-- 性別はログイン情報からユーザー名を取得 -->
                <div class="form-group">
                    <label for="gender">
                        性別
                    </label>
                    @if(Auth::user() != null)
                    <select
                        id="gender"
                        name="gender"
                        class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                        type="hidden" 
                        readonly
                    >
                    @if(Auth::user()->gender === 1)
                    <option value="1">男性</option>
                    @elseif(Auth::user()->gender === 2)
                    <option value="2">女性</option>
                    @else
                    <option value="0">どちらでもない</option>
                    @endif
                    </select>
                    @else
                    <select id="gender" type="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ old('gender') }}" required>
                        <option value="">選択</option>
                        <option value="1">男性</option>
                        <option value="2">女性</option>
                        <option value="0">どちらでもない</option>
                    </select>
                    @endif
                        
                    <option value="" selected></option>
                    @if ($errors->has('gender'))
                        <div class="invalid-feedback">
                            {{ $errors->first('gender') }}
                        </div>
                    @endif
                </div>

                <!-- 年齢はログイン情報からユーザー名を取得 -->
                <div class="form-group">
                    <label for="age">
                        年齢
                    </label>
                    @if(Auth::user() != null)
                    <input
                        id="age"
                        name="age"
                        class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}"
                        value="{{Auth::user()->age}}"
                        readonly
                    >
                    @else
                    <input id="age" type="age" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" maxlength="3" pattern="\d{1,3}" required>
                    @endif
                        
                    <option value="" selected></option>
                    @if ($errors->has('age'))
                        <div class="invalid-feedback">
                            {{ $errors->first('age') }}
                        </div>
                    @endif
                </div>
 
                <div class="form-group">
                    <label for="city">
                        市区町村を選択してください
                    </label>
                    <select
                        id="city_id"
                        name="city_id"
                        class="form-control {{ $errors->has('city_id') ? 'is-invalid' : '' }}"
                        value="{{ old('city_id') }}"   
                    >

                    <!-- 市区町村が選択されている場合、初期値をその市区町村に設定 -->
                        @if(isset($city_id))
                        <option value="{{ $city_id }}" selected>{{ $city_name->city_name }}</option>
                        @endif"
                    
                        @foreach($cities as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('city_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city_id') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="immigrant">
                        その市区町村との関係を選択してください
                    </label>
                    <select
                        id="immigrant"
                        name="immigrant"
                        class="form-control {{ $errors->has('immigrant') ? 'is-invalid' : '' }}"
                        value="{{ old('immigrant') }}"   
                    >
                        <option value="">選択</option>
                        <option value="0">出身者</option>
                        <option value="1">移住者</option>
                    </select>

                    @if ($errors->has('city_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city_id') }}
                        </div>
                    @endif
                </div>

                <div class="d-flex" style="align-items:end;">
                    <div class="form-group">
                        <label for="start">
                            居住期間
                            <p class="text-secondary mb-0">※数字4ケタで入力ください。</p>
                        </label>
                        <input
                            id="start"
                            name="start"
                            class="form-control {{ $errors->has('start') ? 'is-invalid' : '' }}"
                            value="{{ old('start') }}"
                            type="intger"
                            maxlength="4"
                            pattern="\d{4,4}"
                        >
                        @if ($errors->has('start'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start') }}
                            </div>
                        @endif
                    </div>

                    <p>年<span class="ml-2">～</p>
                    <div class="form-group ml-3">
                        <label for="end">
                        </label>
                        <input
                            id="end"
                            name="end"
                            class="form-control {{ $errors->has('end') ? 'is-invalid' : '' }}"
                            value="{{ old('end') }}"
                            type="intger"
                            maxlength="4"
                            pattern="\d{4,4}"
                        >
                        @if ($errors->has('end'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end') }}
                            </div>
                        @endif
                    </div>
                    <p>年</p>
                </div>
 
                <div class="form-group">
                    <label for="subject">
                        件名
                    </label>
                    <input
                        id="subject"
                        name="subject"
                        class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                        value="{{ old('subject') }}"
                        type="text"
                    >
                    @if ($errors->has('subject'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subject') }}
                        </div>
                    @endif
                </div>

      
                <p class="mb-1">画像をアップロードする</p> 
                <input type="file" name="imgpath" style="margin-bottom:20px;" accept="image/*" multiple="multiple" >
 
                <div class="form-group">
                    <label for="message">
                        メッセージ
                    </label>
 
                    <textarea
                        id="message"
                        name="message"
                        class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"
                        rows="4"
                    >{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                        <div class="invalid-feedback">
                            {{ $errors->first('message') }}
                        </div>
                    @endif
                </div>
 
                <div class="mt-5">
                    <a class="btn btn-secondary" href="{{ route('{pref_id?}.index', ['pref_id'=>$pref_id,'city_id'=>$city_id])}}">
                        キャンセル
                    </a>
 
                    <button type="submit" class="btn btn-primary">
                        投稿する
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection
 
@include('layouts.bbsfooter')
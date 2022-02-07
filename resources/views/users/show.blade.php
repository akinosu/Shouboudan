@extends('layouts.bbslayout')
@include('layouts.bbsheader')
@section('content')
<div class="container">
    @if (session('poststatus'))
        <div class="alert alert-success mt-4 mb-4">
            {{ session('poststatus') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-10 mb-3">
            <div class="card">
                <div class="d-inline-flex">
                    <div class="p-3 d-flex flex-column">
                    @if ($user->profile_image != null)
                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                    @else
                    <img src="{{ asset('storage/profile_image/20200501_noimage.png') }}" class="rounded-circle" width="50" height="50">
                    @endif
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="mb-0 font-weight-bold">{{ $user->name }}</h4>
                        {{--    <span class="text-secondary">{{ $user->screen_name }}</span> --}}
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">プロフィールを編集する</a>
                                @endif
                            </div>
                        </div>
                       <div class="d-flex justify-content-end">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">投稿数</p>
                                <span>{{ $user_posts_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">もらったいいね数</p>
                                <span>{{ $user_get_nices->count() }}</span>
                            </div>
                            {{--        <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロワー数</p>
                                <span>{{ $follower_count }}</span>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($user_posts))
            @foreach ($user_posts as $user_post)
                <div class="col-md-10 mb-3">
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex flex-wrap">
                            <div class="d-flex flex-grow-1">
                                @if (isset($user_post->user->profile_image))
                                <img src="{{ asset('storage/profile_image/' .$user_post->user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @else
                                <img src="{{ asset('storage/profile_image/20200501_noimage.png') }}" class="rounded-circle" width="50" height="50">
                                @endif
            
                                <div class="ml-2 d-flex flex-column flex-grow-1">
                                    <p class="mb-0 text-nowrap"><a href="{{ route('{pref_id?}.index', ['pref_id'=>$user_post->city->pref_id]) }}" class="mb-0">{{ $user_post->city->pref_name }}</a>
                                    /<a href="{{ route('{pref_id?}.index', ['city_id'=>$user_post->city->id,'pref_id'=>$user_post->city->pref_id]) }}" class="mb-0">{{ $user_post->city->city_name }}</a>のクチコミ</p>
                                    <div class="d-flex flex-grow-1">
                                        <a href="{{url('users/' .$user_post->user_id)}}" class="mb-0 text-nowrap">{{ $user_post->user->name }}</a>
                                        <p class="mb-0 text-secondary text-nowrap">
                                            （
                                            @if ($user_post->gender != null)
                                                @if ($user_post->gender === 1)
                                                    男性
                                                @elseif ($user_post->gender === 2)
                                                    女性
                                                @endif
                                                ・
                                            @endif
                                        </p>
                                        <p class="mb-0 text-secondary text-nowrap">
                                            {{$user_post->age}}歳
                                            ）
                                        </p>
                                    </div>                       
                                </div>
                            </div>
                            <div class="ml-5 d-flex flex-column flex-grow-1" >
                            <p class="mb-0 text-secondary text-nowrap mb-1">
                            <span class="text-white bg-primary" style="padding:1.5px;">居住期間</span>
                                @if ($user_post->end != null)
                                    @if ($user_post->start != null)
                                        {{$user_post->start}}年
                                        <span>~</span>
                                        {{$user_post->end}}年
                                    @else
                                         <span>~</span>
                                        {{$user_post->end}}年
                                    @endif
                                @elseif ($user_post->start != null)
                                    {{$user_post->start}}年
                                    <span>~</span>
                                @else
                                    不明
                                @endif

                                <p class="mb-0 text-secondary text-nowrap">
                                <span class="text-white bg-primary" style="padding:1.5px;">地域との関係</span>
                                    @if ($user_post->immigrant === 0)
                                        出身者
                                        @else
                                        移住者
                                    @endif
                                </p>
                            
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-title">
                             <h5><a href="{{ route('show' ,['post_id'=>$user_post->id, 'pref_id'=>$user_post->city->pref_id, 'city_id'=>$user_post->city_id, 'user_post_id'=>$user_post->user_id]) }}">{{ $user_post->subject }}</a></h5>
                            </div>
                            {{ $user_post->message }}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white flex-wrap">
                            <div class="d-flex justify-content-start flex-grow-1">
                                <p class="mb-0 text-secondary">ID:{{ $user_post->id }}</p>
                            </div>
                            <div class="d-flex justify-content-start flex-grow-1">
                            <p class="mb-0 text-secondary">投稿日時:{{ $user_post->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                            @if ($user_post->image != null)
                            <div class="mr-3 d-flex align-items-center">
                                <a href=""><i class="far fa-image fa-fw fa-lg"></i></a>
                                <p class="mb-0 text-secondary">画像あり</p>
                            </div>
                            @endif
                            <div class="mr-3 d-flex align-items-center">
                                <a href="{{ route('show_comment' ,['post_id'=>$user_post->id, 'pref_id'=>$user_post->city->pref_id, 'city_id'=>$user_post->city_id, 'user_post_id'=>$user_post->user_id,'comment'=>'#comment']) }}"><i class="far fa-comment fa-fw fa-lg"></i></a>
                                <p class="mb-0 text-secondary">{{ count($user_post->comments) }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                    <!-- $nice(既にipで抽出済)を$user_post_idのみ抽出し配列にし、$user_post->idの値がその中にあるかどうかの真偽式 -->
                                @if (!in_array($user_post->id, array_column($nices->toArray(), 'post_id'), TRUE))
                                    <a class="far fa-heart fa-fw fa-lg" style="text-decoration: none;" href="{{ url('pref/'.$user_post->city->pref_id.'/nice/'.$user_post->id) }}" class="mb-0"></a>
                                @else
                                    <a class="fas fa-heart fa-fw fa-lg" style="text-decoration: none;" href="{{ url('pref/'.$user_post->city->pref_id.'/unnice/'.$user_post->id) }}" class="mb-0"></a>
                                @endif
                                <p class="mb-0 text-secondary">{{ count($user_post->nices) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="my-4 d-flex justify-content-center">
        {{ $user_posts->links() }}
    </div>
</div>
@endsection

@include('layouts.bbsfooter')
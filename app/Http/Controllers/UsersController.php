<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\user;
use App\Services\PostService;
use App\Services\NiceService;
use App\Services\CityService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Exception;

class UsersController extends Controller
{
    public function __construct(PostService $postService, NiceService $niceService, CityService $cityService, UserService $userService)
    {
        $this->postService = $postService;
        $this->niceService = $niceService;
        $this->cityService = $cityService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        try {
            $login_user = auth()->user();
            $user_posts = $this->postService->getUserPost($user->id);
            $user_posts_count = $this->postService->getPostCount($user->id);
            $user_get_nices = $this->niceService->getUserNices($user->id);
            $nices = $this->niceService->getNiceSearchIP($request);

            return view('users.show', [
            'user'               => $user,
            'user_posts'         => $user_posts,
            'user_posts_count'   => $user_posts_count,
            'user_get_nices'     => $user_get_nices,
            'nices'     => $nices,
        ]);
        } catch (Exception $e) {
            report($e);
            echo "エラーが発生しました。";
            return;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);
            
            $validator->validate();
            $this->userService->updateProfile($data);
            return redirect('users/'.$user->id);
        } catch (Exception $e) {
            report($e);
            echo "エラーが発生しました。";
            return;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

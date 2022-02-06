<?php
namespace App\Http\Controllers;

class ViewController extends Controller
{
    public function switch()
    {
        return view('view.switch', ['random'=>random_int(1, 5)]);
    }

    public function master()
    {
        return view('view.master', ['msg'=>'Hello World!',]);
    }

    public function show($id)
    {
        // return view('user.profile', ['user' => User::findOrFail($id)]);
        return view('view.pref.'.$id);
    }
}

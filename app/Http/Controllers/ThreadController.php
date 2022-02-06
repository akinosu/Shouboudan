<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThreadController extends Controller
{
    //
    public function index()
    {
        return view('threads.index');
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        dd([
            $request->title,
            $request->body,
            ]);
    }
}

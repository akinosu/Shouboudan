<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nice extends Model
{
    //
    public function user() {
        return $this->belongsTo(User::class);
    }
 
    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function getUserNices($user_id) {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }

    public function getNices($ip) {
        // $ip = $request->ip();
        $nices = Nice::where('ip', $ip)->get();
        return $nices;
    }
}

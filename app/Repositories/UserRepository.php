<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function updateProfile($params)
    {
        $user_id = auth()->user()->id;
        DB::beginTransaction();
        try {
            if (isset($params['profile_image'])) {
                $file_name = $params['profile_image']->store('public/profile_image/');
                $user = User::where('id', $user_id)->first();
                $user->name = $params['name'];
                $user->profile_image = basename($file_name);
                $user->email = $params['email'];
                $user->save();
            } else {
                $user = User::where('id', $user_id)->first();
                $user->name = $params['name'];
                $user->email = $params['email'];
                $user->save();
            }
            DB::commit();
            return;
        } catch (Exception $e) {
            report($e);
            echo "エラーが発生しました。";
            DB::rollBack();
        }
    }
}

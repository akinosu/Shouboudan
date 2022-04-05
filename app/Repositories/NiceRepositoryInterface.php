<?php

namespace App\Repositories;

interface NiceRepositoryInterface
{
    public function nice($request);
    public function unnice($request);
    public function getNiceSearchIP($ip);
    public function getUserNices($user_id);
}

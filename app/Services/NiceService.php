<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\NiceRepositoryInterface;

class NiceService
{
    public function __construct(NiceRepositoryInterface $niceRepo)
    {
        $this->niceRepositry = $niceRepo;
    }

    public function nice($request)
    {
        return $this->niceRepositry->nice($request);
    }

    public function unnice($request)
    {
        return $this->niceRepositry->unnice($request);
    }

    public function getNiceSearchIP(Request $request)
    {
        $ip = $request->ip();
        return $this->niceRepositry->getNiceSearchIP($ip);
    }

    public function getUserNices($user_id)
    {
        return $this->niceRepositry->getUserNices($user_id);
    }
}

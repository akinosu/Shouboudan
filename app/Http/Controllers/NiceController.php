<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NiceService;

class NiceController extends Controller
{
    public function __construct(NiceService $niceService)
    {
        $this->niceService = $niceService;
    }

    public function nice(Request $request)
    {
        return $this->niceService->nice($request);
    }

    public function unnice(Request $request)
    {
        return $this->niceService->unnice($request);
    }
}

<?php

namespace App\Services;

use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepositoryInterface;

class CommentService
{
    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->cityRepositry = $commentRepo;
    }

    public function store(CommentRequest $request)
    {
        return $this->cityRepositry->store($request);
    }
}

<?php
namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;

use App\Services\CommentService;
 
class CommentsController extends Controller
{
    public function __construct(CommentService $commentService)
    {
        $this->CommentService = $commentService;
    }
  
    public function store(CommentRequest $request)
    {
        return $this->CommentService->store($request);
    }
}

<?php

namespace App\Http\Controllers\Api\JustGram\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\JustGram\v1\BaseController;
use App\Repositories\Api\v1\PostRepository;

class PostController extends BaseController
{
    protected $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    public function create(Request $request)
    {
        $task = $this->post->attemptCreate($request);

        if($task['state']) {
		    return BaseController::defaultSuccessResponse([]);
	    } else {
		    return BaseController::defaultErrorResponse([
			    'message' => $task['message']
		    ]);
	    }
    }

    public function index(Request $request)
    {
        $task = $this->post->attemptGetPostList($request);

        if($task['state']) {
		    return BaseController::firstSuccessResponse([
                'data' => $task['data']
            ]);
	    } else {
		    return BaseController::defaultErrorResponse([
			    'message' => $task['message']
		    ]);
	    }
    }

    public function comment_create(Request $request)
    {
        $task = $this->post->attemptCommentCreate($request);

        if($task['state']) {
		    return BaseController::defaultSuccessResponse([]);
	    } else {
		    return BaseController::defaultErrorResponse([
			    'message' => $task['message']
		    ]);
	    }
    }
}

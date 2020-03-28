<?php

namespace App\Traits\Model;

use App\Traits\Model\BaseModelTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use \App\Models\JustGram\Posts;
use \App\Models\JustGram\PostsTag;
use \App\Models\JustGram\PostsImage;
use \App\Models\JustGram\PostsComments;

/**
 * posts 관련 트레이트.
 */
trait PostsTrait {
	// use BaseModelTrait;

    // 모델 공통 Trait
	use BaseModelTrait {
		BaseModelTrait::controlOneDataResult as controlOneDataResult;
	}

    public function createPost(array $params)
    {
        $task = Posts::create([
            'user_id' => $params['user_id'],
            'contents' => $params['contents'],
        ]);

        if(!$task) {
            return false;
        }

        return $task->id;
    }

    public function createTags(array $params)
    {
        $task = PostsTag::create([
            'post_id' => $params['post_id'],
            'hash_tag' => $params['hash_tag']
        ]);

        if(!$task) {
            return false;
        }

        return $task->id;
    }

    public function createPostImage(array $params)
    {
        $task = PostsImage::create([
            'post_id' => $params['post_id'],
            'image_id' => $params['image_id'],
        ]);

        if(!$task) {
            return false;
        }

        return $task->id;
    }

    public function getPostListMaster()
    {
        return self::controlDataObjectResult(Posts::with(['user', 'user.profileImage' => function($query) {
            $query->where('image_category', 'A22010');
        }, 'tag', 'image', 'image.cloudinary', 'comment' => function($query) {
            $query->orderBy('id', 'desc');
        }, 'comment.user'])->where('post_active', 'Y')->latest()->get());
    }

    public function createPostsComment(array $params)
    {
        $task = PostsComments::create([
            'post_id' => $params['post_id'],
            'user_id' => $params['user_id'],
            'contents' => $params['contents'],
        ]);

        if(!$task) {
            return false;
        }

        return $task->id;
    }
}

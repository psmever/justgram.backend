<?php

namespace App\Traits\Model;

use App\Traits\Model\BaseModelTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use \App\Models\JustGram\Posts;
use \App\Models\JustGram\PostsTag;
use \App\Models\JustGram\PostsImage;
use \App\Models\JustGram\PostsComments;
use \App\Models\JustGram\PostsHeart;

/**
 * posts 관련 트레이트.
 */
trait PostsTrait {

    use BaseModelTrait;

    public static function existsPost($post_id)
    {
        return Posts::where('id', $post_id)->exists();
    }

    public static function createPost(array $params)
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

    public static function createTags(array $params)
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

    public static function createPostImage(array $params)
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

    public static function getPostListMaster($user_id = null)
    {
        return BaseModelTrait::controlDataObjectResult(Posts::with(['user', 'user.profileImage' => function($query) {
            $query->where('image_category', 'A22010');
        }, 'tag', 'image' => function($query) {$query->whereNotNull('id');}, 'image.cloudinary', 'comment' => function($query) {
            $query->orderBy('id', 'desc');
        }, 'comment.user'])->withCount(['myheart'=> function($q) use ($user_id) {
            if($user_id) {
                $q->where('user_id', $user_id);
            }
        }, 'hearts'])->where('post_active', 'Y')->latest()->get());
    }

    public static function createPostsComment(array $params)
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

    public static function addPostsHeart(int $user_id, int $post_id) : int
    {
        $task = PostsHeart::create([
            'user_id' => $user_id,
            'post_id' => $post_id,
        ]);

        if(!$task) {
            return false;
        }

        return $task->id;
    }

    public static function deletePostsHeart(int $user_id, int $post_id) : bool
    {
        return PostsHeart::where('user_id', $user_id)->where('post_id', $post_id)->delete();
    }
}

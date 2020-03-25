<?php
namespace App\Repositories\Api\v1;

use App\Repositories\Api\v1\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;

use App\Traits\Model\PostsTrait;
use App\Traits\Model\CloudinaryTrait;
use Carbon\Carbon;
use App\Helpers\MasterHelper;

class PostRepository implements PostRepositoryInterface
{
    use CloudinaryTrait, PostsTrait;

	public function start()
	{
    }

    public function attemptCreate(Request $request) : array
    {
		$validator = FacadesValidator::make($request->all(), [
            'upload_image' => 'required',
			'tags' => 'required',
            'contents' => 'required',
        ]);

        if( $validator->fails() ) {
            $errorMessage = $validator->getMessageBag()->all();
			return [
				'state' => false,
				'message' => $errorMessage[0]
			];
		}

        $User = Auth::user();

        $postTask = self::createPost([
            'user_uuid' => $User->user_uuid,
            'contents' => $request->input('contents')
        ]);

        if(!$postTask) {
            return [
                'state' => false,
                'message' => __('messages.default.error')
            ];
        }

        $post_id = $postTask;
        $tagsTask = false;

        //테그 처리.
        try {
            $tagsTask = self::createTags([
                'post_id' => $post_id,
                'hash_tag' => implode(',', json_decode(html_entity_decode(stripslashes($request->input('tags')))))
            ]);
        } catch (\Exception $e) {
            throw new \App\Exceptions\CustomException($e->getMessage());
        }

        if(!$tagsTask) {
            return [
                'state' => false,
                'message' => __('messages.default.error')
            ];
        }

        $imageTask = false;
        try {

            $imageInfo = json_decode(html_entity_decode(stripslashes($request->input('upload_image'))));

            $imageTask = self::setUserPostImageCloudinaryData([
                'user_uuid' => $User->user_uuid,
                'public_id' => $imageInfo->public_id,
                'signature' => $imageInfo->signature,
                'version' => $imageInfo->version,
                'width' => $imageInfo->width,
                'height' => $imageInfo->height,
                'format' => $imageInfo->format,
                'original_filename' => $imageInfo->original_filename,
                'url' => $imageInfo->url,
                'secure_url' => $imageInfo->secure_url,
                'bytes' => $imageInfo->bytes,
                'server_time' => $imageInfo->created_at,
            ]);

        } catch (\Exception $e) {
            throw new \App\Exceptions\CustomException($e->getMessage());
        }

        if(!$imageTask) {
            return [
                'state' => false,
                'message' => __('messages.default.error')
            ];
        }

        $postImage_id = $imageTask;


        $postImageTask = self::createPostImage([
            'post_id' =>  $post_id,
            'image_id' => $postImage_id
        ]);

        if(!$postImageTask) {
            return [
                'state' => false,
                'message' => __('messages.default.error')
            ];
        }

        return [
            'state' => true
        ];
    }

    public function attemptUpdate(Request $request)
    {
    }

    public function attemptGetPostList(Request $request)
    {
        $posts = self::getPostListMaster();

        if(!$posts['state']) {
            return [
                'state' => false,
                'message' => __('messages.exits_value.posts')
            ];
        }


        $returnObject = array_map( function ($element) {
            // print_r($element);
            $user = function($user) {
                return [
                    'user_id' => $user['id'],
                    'user_name' => $user['user_name'],
                    'user_email' => $user['email'],
                    'user_profile_image' => isset($user['profile_image']['secure_url']) && $user['profile_image']['secure_url'] ? $user['profile_image']['secure_url'] : NULL,
                ];
            };

            $hash_tag = function($tag) {
                $listArray = explode(",", $tag['hash_tag']);
                return [
                    'list' => $listArray,
                    'string' => "#".implode(' #', $listArray)
                ];
            };

            $image_info = function($image) {

                $cloudinary = function($cloudinary) {
                    return [
                        'cloudinary_id' => $cloudinary['id'],
                        'url' => $cloudinary['url'],
                        'secure_url' => $cloudinary['secure_url']
                    ];
                };

                return [
                    'image_id' => $image['id'],
                    'cloudinary' => $cloudinary($image['cloudinary']),
                ];
            };

            $comment = function($comment) {
                return array_map(function($element) {

                    $user = function($user) {
                        return [
                            'user_name' => $user['user_name'],
                        ];
                    };

                    return [
                        'comment_id' => $element['id'],
                        'user_uuid' => $element['user_uuid'],
                        'contents' => $element['contents'],
                        'created_at' => $element['created_at'],
                        'user' => $user($element['user'])
                    ];

                }, $comment);
            };

            return [
                'post_id' => $element['id'],
                'user_uuid' => $element['user_uuid'],
                'contents' => $element['contents'],
                'user_info' => $user($element['user']),
                'tags' => $hash_tag($element['tag']),
                'image' => $image_info($element['image']),
                'post_datetime' => [
                    'create_at' => $element['created_at'],
                    'create_at_string' => Carbon::parse($element['created_at'])->format('Y년 m월 d일 H시:s분'),
                    'create_time_string' => MasterHelper::convertTimeToString(strtotime($element['updated_at'])),
                    'update_at' => $element['updated_at'],
                    'update_at_string' => Carbon::parse($element['updated_at'])->format('Y년 m월 d일 H시:s분'),
                    'update_time_string' => MasterHelper::convertTimeToString(strtotime($element['updated_at'])),
                ],
                'comments' => $comment($element['comment'])
            ];
        }, $posts['data']);


        return [
            'state' => true,
            'data' => $returnObject
        ];
    }

    public function attemptCommentCreate($request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'post_id' => 'required',
            'contents' => 'required',
        ]);

        if( $validator->fails() ) {
            $errorMessage = $validator->getMessageBag()->all();
			return [
				'state' => false,
				'message' => $errorMessage[0]
			];
        }

        $User = Auth::user();

        $createTask = self::createPostsComment([
            'post_id' => $request->input('post_id'),
            'user_uuid' => $User->user_uuid,
            'contents' => $request->input('contents'),
        ]);

        if(!$createTask) {
            return [
                'state' => false,
                'message' => __('messages.default.error')
            ];
        }

        return ['state' => true];
    }
}

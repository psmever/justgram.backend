<?php
namespace App\Repositories\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

use App\Traits\Model\UserTrait;

class UserRepository implements UserRepositoryInterface
{
    use UserTrait;

    private $UserUUID;
    private $UserID;

	public function start() {

    }

    /**
     * 사용자 체크.
     *
     * @param string $user_name
     * @return array
     */
    public function checkUser(string $user_name = NULL) : array {

        if(empty($user_name)) {
            return [
                "state" => false,
                "message" => __('messages.exits_value.user'),
            ];
        }

        $checkResult = self::checkExitsUserName($user_name);

        if ($checkResult['state'] == false) {
            return [
                "state" => false,
                "message" => __('messages.exits.user'),
            ];
        }
        //TODO: 사용자 상태 체크를 어떻게 할지?
        $this->UserUUID = $checkResult['data']['user_uuid'];
        $this->UserID = $checkResult['data']['user_id'];

        return [
            "state" => true,
        ];
    }

    /**
     * 사용자 프로필 정보 전달.
     *
     * @return void
     */
    public function getUserProfileData() {
        $task = self::secondGetUserProfileData($this->UserID);
        if(!$task['state']) {
            return [
                'state' => false,
                'message' => __('messages.exits.data'),
            ];
        }

        $returnObject = function() use ($task) {
            $data = $task['data'];
            return [
                'user_uuid' => $data['user_uuid'],
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'profile_image' => [
                    'url' => $data['profile_image']['url'],
                    'secure_url' => $data['profile_image']['secure_url'],
                ],
                'count_info' => [
                    "posts" => $data['posts_count'],
                    "followers" => $data['followers_count'],
                    "following" => $data['following_count'],
                ],
                'profile' => [
                    'name' => $data['profile']['name'],
                    'web_site' => $data['profile']['web_site'],
                    'bio' => $data['profile']['bio'],
                    'gender' => $data['profile']['gender'],
                    'phone_number' => $data['profile']['phone_number'],
                ],
                'posts' => array_map(function($element){
                    return [
                        'post_id' => $element['id'],
                        'image' => [
                            'id' => $element['image']['cloudinary']['id'],
                            'url' => $element['image']['cloudinary']['url'],
                            'secure_url' => $element['image']['cloudinary']['secure_url'],
                        ],
                        'count' => [
                            'comment_count' => rand(0,100),
                            'heart_count' => rand(0,1000)
                        ]
                    ];
                },$data['posts'])
            ];
        };

        return [
            'state' => true,
            'data' => $returnObject()
        ];
    }

    /**
     * 팔로워 등록, 요청.
     *
     * @param Request $request
     * @return void
     */
    public function create_follow(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'target_user_id' => 'required|exists:tbl_users_master,id'
        ]);

		if( $validator->fails() ) {
            $errorMessage = $validator->getMessageBag()->all();
			return [
				'state' => false,
				'message' => $errorMessage[0]
			];
		}

        $user_id = Auth::id();
        $target_user_id = $request->input('target_user_id');

        $checkTask = self::checkExistsFollowTarget($user_id, $target_user_id);
        if($checkTask) {
            return [
                'state' => false,
                'message' => __('messages.error.already')
            ];
        }

        $createTask = self::createFollowTarget($user_id, $target_user_id);

        return [
            'state' => true,
        ];
    }

    /**
     * 팔로우 삭제, 언팔.
     *
     * @param Request $request
     * @return void
     */
    public function delete_follow(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'target_user_id' => 'required|exists:tbl_users_master,id'
        ]);

		if( $validator->fails() ) {
            $errorMessage = $validator->getMessageBag()->all();
			return [
				'state' => false,
				'message' => $errorMessage[0]
			];
        }

        $user_id = Auth::id();
        $target_user_id = $request->input('target_user_id');

        $checkTask = self::checkExistsFollowTarget($user_id, $target_user_id);
        if(!$checkTask) {
            return [
                'state' => false,
                'message' => __('messages.exits.table_user')
            ];
        }

        $deleteTask = self::deleteFollowTarget($user_id, $target_user_id);

        return [
            'state' => true,
        ];
    }

    /**
     * Following 리스트
     *
     * @return void
     */
    public function makeFollowingList(string $user_name)
    {
        $checkResult = self::checkExitsUserName($user_name);

        if ($checkResult['state'] == false) {
            return [
                "state" => false,
                "message" => __('messages.exits.user'),
            ];
        }
        $user_id = $checkResult['data']['user_id'];

        $task = self::taskMakeUserFollowing($user_id);

        if(!$task->isNotEmpty()) {
            return [
                'state' => false,
                'message' => __('messages.exits.data')
            ];
        }

        $taskFirstToArray = $task->first()->toArray();
        return [
            'state' => true,
            'data' => [
                'user_id' => $taskFirstToArray['id'],
                'user_uuid' => $taskFirstToArray['user_uuid'],
                'user_name' => $taskFirstToArray['user_name'],
                'email' => $taskFirstToArray['email'],
                'following_list' => array_map(function($element) {
                   return [
                       'user_id' => $element['target_id'],
                       'created_at' => $element['created_at'],
                       'user_name' => $element['target']['user_name'],
                       'user_uuid' => $element['target']['user_uuid'],
                       'user_profile_name' => $element['target']['profile']['name'],
                       'profile_image' => $element['target']['profile_image']['secure_url'],
                       'mefollowing' => ($element['target']['mefollowing_count']) ? true : false,
                   ];
                }, $taskFirstToArray['following'])
            ]
        ];
    }

    /**
     * Followers 리스트
     *
     * @return void
     */
    public function makeFollowersList(string $user_name)
    {
        $checkResult = self::checkExitsUserName($user_name);

        if ($checkResult['state'] == false) {
            return [
                "state" => false,
                "message" => __('messages.exits.user'),
            ];
        }
        $user_id = $checkResult['data']['user_id'];

        $task = self::taskMakeUserFollowers($user_id);

        if(!$task->isNotEmpty()) {
            return [
                'state' => false,
                'message' => __('messages.exits.data')
            ];
        }

        $taskFirstToArray = $task->first()->toArray();

        return [
            'state' => true,
            'data' => [
                'user_id' => $taskFirstToArray['id'],
                'user_uuid' => $taskFirstToArray['user_uuid'],
                'user_name' => $taskFirstToArray['user_name'],
                'email' => $taskFirstToArray['email'],
                'followers_list' => array_map(function($element) {
                   return [
                       'user_id' => $element['user_id'],
                       'created_at' => $element['created_at'],
                       'user_name' => $element['user']['user_name'],
                       'user_uuid' => $element['user']['user_uuid'],
                       'user_profile_name' => $element['user']['profile']['name'],
                       'profile_image' => $element['user']['profile_image']['secure_url'],
                       'targetfollowing' => ($element['user']['targetfollowing_count']) ? true : false,
                   ];
                }, $taskFirstToArray['followers'])
            ]
        ];
    }
}

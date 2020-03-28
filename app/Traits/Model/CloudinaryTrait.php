<?php

namespace App\Traits\Model;

use App\Traits\Model\BaseModelTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


use \App\Models\JustGram\UsersMaster;
use \App\Models\JustGram\CloudinaryImageMaster;
use \App\Models\JustGram\UserProfiles;
use \App\Models\JustGram\EmailAuth;

/**
 * 이미지 관련 Trait 모음.
 * @package App\Traits\Model
 */
trait CloudinaryTrait {
	// use BaseModelTrait;

    // 모델 공통 Trait
	use BaseModelTrait {
		BaseModelTrait::controlOneDataResult as controlOneDataResult;
	}

    public function setUserProfileImageCloudinaryData(array $params) : array
    {
        // 있으면 업데이트 없으면 생성.
		$task = CloudinaryImageMaster::updateOrCreate([
                'user_id' => $params['user_id']
            ],[
                'image_category' => USER_PROFILE_IMAGE,
                'public_id' => $params['public_id'],
                'signature' => $params['signature'],
                'version' => $params['version'],
                'width' => $params['width'],
                'height' => $params['height'],
                'format' => $params['format'],
                'original_filename' => $params['original_filename'],
                'url' => $params['url'],
                'secure_url' => $params['secure_url'],
                'bytes' => $params['bytes'],
                'server_time' => $params['created_at'],
            ]);

		if($task) {
			return [
                'state' => true,
                'id' => $task->id,
            ];
		} else {
			return ['state' => false];
		}
    }

    public function setUserPostImageCloudinaryData(array $params)
    {
        // 있으면 업데이트 없으면 생성.
		$task = CloudinaryImageMaster::create([
            'user_id' => $params['user_id'],
            'image_category' => USER_POST_IMAGE,
            'public_id' => $params['public_id'],
            'signature' => $params['signature'],
            'version' => $params['version'],
            'width' => $params['width'],
            'height' => $params['height'],
            'format' => $params['format'],
            'original_filename' => $params['original_filename'],
            'url' => $params['url'],
            'secure_url' => $params['secure_url'],
            'bytes' => $params['bytes'],
            'server_time' => $params['server_time'],
        ]);

        if(!$task) {
            return false;
        }

        return $task->id;
    }
}

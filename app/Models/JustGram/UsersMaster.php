<?php

namespace App\Models\JustGram;

use App\Models\BaseAuthModel as BaseAuthModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\JustGram\UsersProfiles;

class UsersMaster extends BaseAuthModel implements MustVerifyEmail
{
	use HasApiTokens, Notifiable;

	protected $table = "tbl_users_master";
//	public $incrementing = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_name', 'email', 'password', 'user_uuid', 'user_type', 'profile_active'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

    /**
     * 이메일 인증 테이블.
     *
     * @return void
     */
	public function emailauth() {
		return $this->hasOne('App\Models\JustGram\EmailAuth', 'user_uuid', 'user_uuid');
    }

    /**
     * 사용자 프로필 정보 테이블.
     *
     * @return void
     */
    public function profile() {
        return $this->hasOne('App\Models\JustGram\UserProfiles', 'user_uuid', 'user_uuid');
    }

    public function profileImage() {
        return $this->hasOne('App\Models\JustGram\CloudinaryImageMaster', 'user_uuid', 'user_uuid');
    }
}

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
    public function emailauth()
    {
		return $this->hasOne(EmailAuth::class, 'user_id', 'user_id');
    }

    /**
     * 사용자 프로필 정보 테이블.
     *
     * @return void
     */
    public function profile()
    {
        return $this->hasOne(UserProfiles::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Posts::class, 'user_id', 'id');
    }
    /**
     * 관계 - 프로필 이미지.
     *
     * @return void
     */
    public function profileImage()
    {
        return $this->hasOne(CloudinaryImageMaster::class, 'id', 'profile_image');
    }

    /**
     * 관계 - 팔러오 리스트
     *
     * @return void
     */
    // public function follow()
    // {
    //     return $this->hasMany(Follows::class, 'user_id', 'id');
    // }

    /**
     * 관계 - 팔로잉.
     *
     * @return void
     */
    public function following()
    {
        return $this->hasMany(Follows::class, 'user_id', 'id');
    }

    /**
     * 관계 나를 팔로워 한 사람.
     *
     * @return void
     */
    public function followers()
    {
        return $this->hasMany(Follows::class, 'target_id', 'id');
    }

    /**
     * 관계 - 내가 팔러우 하고 있는지.
     *
     * @return void
     */
    public function mefollowing()
    {
        return $this->hasOne(Follows::class, 'user_id', 'id');
    }

    /**
     * 관계 나를 팔러우 하고 있는지.
     *
     * @return void
     */
    public function targetfollowing()
    {
        return $this->hasOne(Follows::class, 'target_id', 'id');
    }

    /**
     * 관계 - 나를 팔러우 하고 있는지 체크용.
     *
     * @return void
     */
    public function following_count()
    {
        return $this->hasOne(Follows::class, 'user_id', 'id');
    }
}

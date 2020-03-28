<?php

namespace App\Models\JustGram;

use App\Models\BaseModel as BaseModel;

class EmailAuth extends BaseModel
{

	protected $table = "tbl_email_auth_master";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'auth_code'
	];


	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'verified_at' => 'datetime',
	];

	public function users()
	{
		return $this->belongsTo('App\Models\JustGram\UsersMaster', 'user_id' , 'id');
	}


	/**
	 * 사용자 이메일 인증 코드 체크
	 * @param null $authCode
	 * @return array
	 */
	public function scopeExistsAuthCode($query, $authCode = NULL)
	{
//		print_r($query->where('auth_code', $authCode)->get());

//		return static::controlOneDataResult(self::userEmailAuth('auth_code', $authCode)->get());
//		return static::controlOneDataResult(self::where('auth_code', $authCode)->get());
//		return static::controlOneDataResult($this->userEmailAuth()->where('auth_code', $authCode)->get());

//		return static::controlOneDataResult(static::userEmailAuth()->where('auth_code', $authCode)->get());
	}

}

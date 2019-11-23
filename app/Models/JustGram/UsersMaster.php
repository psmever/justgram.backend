<?php

namespace App\Models\JustGram;

use App\Models\BaseAuthModel as BaseAuthModel;
use App\Traits\Model\BaseModelTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UsersMaster extends BaseAuthModel
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
		'name', 'email', 'password',
		'user_uuid',
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
}

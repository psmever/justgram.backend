<?php

namespace App\Models\JustGram;

use Illuminate\Database\Eloquent\Model;

class UserPrifile extends Model
{
	protected $table = "tbl_users_profile_master";

	/**
	 * The primary key associated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'user_uuid';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_uuid', 'real_name', 'web_site', 'about', 'telephone', 'gender'
	];


	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
//		'verified_at' => 'datetime',
	];

	public function users()
	{
		return $this->belongsTo('App\Models\JustGram\UsersMaster', 'user_uuid' , 'user_uuid');
	}
}

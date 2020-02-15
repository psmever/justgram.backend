<?php

namespace App\Models\JustGram;

use Illuminate\Database\Eloquent\Model;

class UserProfiles extends Model
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
		'user_uuid', 'name', 'web_site', 'bio', 'phone_number', 'gender'
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

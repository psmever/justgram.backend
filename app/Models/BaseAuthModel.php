<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\Model\BaseModelTrait;

class BaseAuthModel extends Authenticatable
{
	use HasApiTokens, Notifiable;
	use BaseModelTrait;

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		self::creating(function($model){
//			echo "creating";
		});

		self::created(function($model){
//			echo "created";
		});

		self::updating(function($model){
//			echo "updating";
		});

		self::updated(function($model){
//			echo "updated";
		});

		self::deleting(function($model){
//			echo "deleting";
		});

		self::deleted(function($model){
//			echo "deleted";
		});
	}
}

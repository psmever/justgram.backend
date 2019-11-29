<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Model\BaseModelTrait;

class BaseModel extends Model
{
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

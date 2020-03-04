<?php

namespace App\Models\JustGram;

use Illuminate\Database\Eloquent\Model;

class CloudinaryImageMaster extends Model
{
    protected $table = "tbl_cloudinary_images_master";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
        'user_uuid',
        'image_category',
        'public_id',
        'signature',
        'version',
        'width',
        'height',
        'format',
        'original_filename',
        'url',
        'secure_url',
        'bytes',
        'server_time',
	];


	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'verified_at' => 'datetime',
	];
}

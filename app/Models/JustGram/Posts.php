<?php

namespace App\Models\JustGram;

use App\Models\BaseModel as BaseModel;

class Posts extends BaseModel
{
    protected $table = "tbl_posts_master";

    	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_uuid', 'contents', 'post_active'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
    protected $casts =  [];

    public function user()
    {
        return $this->hasOne(UsersMaster::class, 'user_uuid', 'user_uuid');
    }

    public function tag()
    {
        return $this->hasOne(PostsTag::class, 'post_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(PostsImage::class, 'post_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(PostsComments::class, 'post_id', 'id');
    }


}

<?php

namespace App\Models\JustGram;

use App\Models\BaseModel as BaseModel;

class PostsImage extends BaseModel
{
    protected $table = "tbl_posts_image_master";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'image_id'
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
    protected $casts = [];

    public function cloudinary()
    {
        return $this->hasOne(CloudinaryImageMaster::class, 'id', 'image_id');
    }
}

<?php

namespace App\Models\JustGram;

use App\Models\BaseModel as BaseModel;

class PostsTag extends BaseModel
{
    protected $table = "tbl_email_auth_master";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'hash_tag'
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
}

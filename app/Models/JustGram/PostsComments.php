<?php

namespace App\Models\JustGram;

use Illuminate\Database\Eloquent\Model;

class PostsComments extends Model
{
    protected $table = "tbl_posts_comments_master";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'user_id', 'contents', 'active'
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

    public function user() {
        return $this->hasOne(UsersMaster::class, 'id', 'user_id');
    }
}

<?php

namespace App\Models\JustGram;

use Illuminate\Database\Eloquent\Model;

class PostsHeart extends Model
{
    protected $table = "tbl_post_hearts_master";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'post_id'
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

    public function hears()
    {
        return $this->hasMany(PostsHeart::class, 'post_id' , 'id');
    }
}

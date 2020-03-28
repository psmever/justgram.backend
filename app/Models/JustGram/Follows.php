<?php

namespace App\Models\JustGram;

use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    protected $table = "tbl_follows_master";
    public $timestamps = false;

	/**
	 * The primary key associated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'user_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'target_id'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
//		'verified_at' => 'datetime',
    ];

    /**
     * 팔로우 타겟 관계.
     *
     * @return void
     */
    public function target()
    {
        return $this->hasOne(UsersMaster::class, 'id', 'target_id');
    }
}

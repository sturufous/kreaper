<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MSDBSongs extends Model
{
	protected $table = 'songs';
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'sqlite';
	public $timestamps = false;
	
	public function lyrics()
	{
		return $this->hasMany('App\Lyrics', 'track_id', 'track_id');
	}
}

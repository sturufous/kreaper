<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Used for accessing the lyrics table that was loaded from Columbia University Text file.
 *
 * @author stuartmorse
 */

class Lyrics extends Model
{
	protected $table = 'lyrics';
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'sqlite';
	
	public function song()
	{
		return $this->belongsTo('App\MSDBSongs', 'track_id', 'track_id');
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KrLyrics extends Model
{
	protected $table = 'kr_lyrics';
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'sqlite';
	public $timestamps = false;
}

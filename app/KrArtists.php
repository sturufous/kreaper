<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KrArtists extends Model
{
	protected $table = 'unique_artists';
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'sqlite';
	public $timestamps = false;
}

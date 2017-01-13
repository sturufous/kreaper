<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Used for accessing the unique_artists table that was loaded from Columbia University Text file.
 *
 * @author stuartmorse
 */

class KrArtists extends Model
{
	protected $table = 'unique_artists';
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'sqlite';
	public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Used for accessing the songs table in Columbia University's metadata database.
 *
 * @author stuartmorse
 */

class KrMetadata extends Model
{
	protected $table = 'songs';
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'metadata';
	public $timestamps = false;
}

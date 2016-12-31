<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KrMetadata extends Model
{
	protected $table = 'songs';
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'metadata';
	public $timestamps = false;
}

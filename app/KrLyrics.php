<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lyrics extends Model
{
	protected $primaryKey = 'track_id';
	public $incrementing = false;
	protected $connection = 'sqlite';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	protected $fillable = ['body', 'user_id'];
	
	function card() {
		
		return $this->belongsTo(Card::class);
	}
	
	function user() {
		
		return $this->belongsTo(User::class);
	}
}

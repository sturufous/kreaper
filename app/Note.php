<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	protected $fillable = ['body', 'user_id'];
	
	// Testing git
	function card() {
		
		return $this->belongsTo(Card::class);
	}
	
	// Testing new branch
	function user() {
		
		return $this->belongsTo(User::class);
	}
}

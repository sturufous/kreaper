<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UniqueArtists extends Migration
{
	public $timestamps = false;
	protected $connection = 'sqlite';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
	
	public function up()
    {
    	Schema::create('unique_artists', function (Blueprint $table) {
    		$table->string('artist_id');
    		$table->string('track_id');
    		$table->string('mbid');
    		$table->string('artist_name');
    		
    		$table->unique('mbid');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

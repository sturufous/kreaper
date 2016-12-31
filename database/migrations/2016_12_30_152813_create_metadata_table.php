<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('songs', function (Blueprint $table) {
    		$table->string('track_id');
    		$table->string('title');
    		$table->string('song_id');
    		$table->string('release');
    		$table->string('artist_id');
    		$table->string('artist_mbid');
    		$table->string('artist_name');
    		$table->float('duration');
    		$table->float('artist_familiarity');
    		$table->float('artist_hotttnesss');
    		$table->integer('year', false, true);
    		$table->integer('track_7digitalid', false, true);
    		$table->integer('shs_perf', false, true);
    		$table->integer('shs_work', false, true);
    				
    		$table->primary('track_id');
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

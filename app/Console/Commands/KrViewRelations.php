<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\KrArtists;
use App\Lyrics;
use App\KrMetadata;
use App\MSDBSongs;
use DB;
use Schema;

class KrViewRelations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kreaper:viewrelations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View results of relationship query';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$columns = Schema::getColumnListing('songs');
    	$this->chunkCount = 0;
    	KrMetadata::chunk(1000, function ($songs) {
    		echo $this->chunkCount * 1000 . "\n";
    		foreach ($songs as $song) {
    			$columns = Schema::getColumnListing('songs');
    			$metadata2 = new MSDBSongs();
    			$idx = 0;
    			foreach($columns as $column) {
    				$metadata2[$columns[$idx]] = $song[$columns[$idx]];
    				$idx++;
    			}
    			$metadata2->save();
    			$this->chunkCount++;
    		}
    	});    	
    }
}

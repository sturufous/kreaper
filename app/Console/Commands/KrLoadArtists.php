<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\KrArtists;
use App\Lyrics;
use DB;

class KrLoadArtists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kreaper:loadartists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load lyrics into KR mysql database';

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
    	$offset = 0;
    	$filename = 'database/unique_artists.txt';
    	if ($fh = fopen($filename, "r")) {
    		while (!feof($fh)) {
    			$line = fgets($fh);
    			$fields = explode('<SEP>', $line);
    			$artist = new KrArtists();
    			$artist->artist_id = $fields[0];
    			$artist->track_id = $fields[1];
    			$artist->mbid = $fields[2];
    			$artist->artist_name = $fields[3];
    			$artist->save();
    		}
    		fclose($fh);
    	}
    	else
    	{
    		echo "Unable to open: $filename\n";
    	}
    }
}

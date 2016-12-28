<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Storage\MusixmatchMusicRepository;
use Storage\MusicRepository as Music;
use Storage\ImageRepository as Images;
use Storage\FantvImageRepository;
use Illuminate\Console\Command;

class Krimages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kreaper:getbandpics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download images for Musixmatch bands';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Music $music, Images $images)
    {
        parent::__construct();
        $this->music = $music;
        $this->images = $images;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Images $images)
    {
    	$bmatch = $this->music->getTopTen();
    	foreach($bmatch->message->body->artist_list as $band)
    	{
    		$images->saveImageLocal(
    			getBandImage($images, $band->artist->artist_mbid),
    			$band->artist->artist_mbid
    		);
    		//echo getBandImage($images, $band->artist->artist_mbid)."<br>";
    	}
    }
}

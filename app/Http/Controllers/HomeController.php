<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage\MusixmatchMusicRepository;
use Storage\MusicRepository as Music;
use Storage\ImageRepository as Images;
use Storage\FantvImageRepository;

class HomeController extends Controller
{
	private $music;
	private $images;
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	
	public function __construct(Music $music, Images $images)
	{
		$this->music = $music;
		$this->images = $images;
        $this->middleware('auth');
	}
	
	/**
	 * Show the application dashboard containing current top ten Musixmatch bands.
	 *
	 * @return \Illuminate\Http\Response
	 */
	
	public function index()
	{
		$bmatch = $this->music->getTopTen();
		
		return view('lists.topten')->with(['data' => $bmatch, 'controller' => $this]);
	}
	
	/**
	 * Choose a band to search for.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function bandEntry()
	{
		return view('inputforms.bandentry');
	}
	
	/**
     * Search for a list of bands filtered by the MSDB repository.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function bandListInMSDB(Request $request)
    {
		$bandName = $request->input('bandname');
		$bmatch = $this->music->findArtist($bandName);
		$request->session()->put('artist_match', $bandName);
		
		// Filter out bands that are NOT in the MSDB
		$filtered = [];
		foreach($bmatch->message->body->artist_list as $band)
		{
			if($this->music->isArtistInMSDB($band->artist->artist_mbid))
			{
				$filtered[] = $band;
			}
		}
        return view('lists.bandlist')->with(['data' => $filtered, 'band' => $bandName]);
    }
    
    /**
     * Search for album list for band in the Musixmatch repository.
     *
     * $request Current HTTP request
     * $artistId The Musixmatch ID for the band
     * @return \Illuminate\Http\Response
     */
    
    public function albumList(Request $request, $artistId)
    {
    	$artist = $this->music->getArtist($artistId);
    	$request->session()->put('artist_name', $artist->message->body->artist->artist_name);
    	$lmatch = $this->music->findAlbums($artistId);
    	return view('lists.albumlist')->with(['data' => $lmatch]);
    }
    
    /**
     * Search for album list for a band in the MSDB repository.
     *
     * $request Current HTTP request
     * $artistId The Musixmatch ID for the band
     * @return \Illuminate\Http\Response
     */
    
    public function albumListInMSDB(Request $request, $artistId)
    {
    	$artist = $this->music->getArtist($artistId);
    	$request->session()->put('artist_name', $artist->message->body->artist->artist_name);
    	$request->session()->put('artist_name', $artist->message->body->artist->artist_name);
    	$request->session()->put('artist_id', $artistId);
    	$request->session()->put('artist_country', $artist->message->body->artist->artist_country);
    	$request->session()->put('artist_twitter', $artist->message->body->artist->artist_twitter_url);

    	getBandImage($this->music, $artist->message->body->artist->artist_mbid);
    	$amatch = $this->music->findAlbums($artistId);
    	 
    	// Include only albums that are in the MSDB
    	$filtered = [];
    	foreach($amatch->message->body->album_list as $album)
    	{
    		if($this->music->isAlbumInMSDB($artist->message->body->artist->artist_mbid, $album->album->album_name))
    		{
    			$filtered[] = $album;
    		}
    	}
    	$request->session()->put('artist_album_count', sizeof($filtered));
    	return view('lists.albumlist')->with(['data' => $filtered]);
    }
    
    /**
     * Search for track list for an album in the MSDB repository.
     *
     * $request Current HTTP request
     * $albumId The Musixmatch Album ID for the band
     * @return \Illuminate\Http\Response
     */
    
    public function trackListInMSDB(Request $request, $albumId)
    {
    	$artist = $this->music->getAlbum($albumId);
    	$request->session()->put('album_name', $artist->message->body->album->album_name);
    	$request->session()->put('album_id', $albumId);
    	$tmatch = $this->music->findTracks($albumId);
    	 
    	// Include only albums that are in the MSDB
    	$filtered = [];
    	foreach($tmatch->message->body->track_list as $track)
    	{
    		if($this->music->isTrackInMSDB($track->track->artist_mbid, $track->track->track_name))
    		{
    			$filtered[] = $track;
    		}
    	}
    	return view('lists.tracklist')->with(['data' => $filtered]);
    }
    
    /**
     * Search for album list for an band in the Musixmatch repository.
     *
     * $request Current HTTP request
     * $albumId The Musixmatch Album ID for the band
     * @return \Illuminate\Http\Response
     */
    
    public function getAlbum(Request $request, $albumId)
    {
    	$lmatch = $this->music->findAlbums($artistId);
    	return view('lists.albumlist')->with(['data' => $lmatch]);
    }
    
    /**
     * Search for track list for an album in the Musixmatch repository.
     *
     * $request Current HTTP request
     * $albumId The Musixmatch Album ID for the band
     * @return \Illuminate\Http\Response
     */
    
    public function trackList(Request $request, $albumId)
    {
    	$artist = $this->music->getAlbum($albumId);
    	$request->session()->put('album_name', $artist->message->body->album->album_name);
    	$tmatch = $this->music->findTracks($albumId);
    	return view('lists.tracklist')->with(['data' => $tmatch]);
    }
    
    /**
     * Search for lyrics for a track in the Musixmatch repository.
     *
     * $request Current HTTP request
     * $trackId The Musixmatch Track ID for the track
     * @return \Illuminate\Http\Response
     */
    
    public function getLyrics(Request $request, $trackId)
    {
    	$track = $this->music->getTrack($trackId);

    	// Get the rating data for the song for display above lyrics
    	$MSDBSong = $this->music->getMSDBSong($track->message->body->track->artist_mbid, $track->message->body->track->track_name);
    	$familiarity = intval($MSDBSong->artist_familiarity * 100);
		$hotness = intval($MSDBSong->artist_hotttnesss * 100);
		$request->session()->put('artist_familiarity', $familiarity);
		$request->session()->put('artist_hotttnesss', $hotness);
		
		$request->session()->put('track_name', $track->message->body->track->track_name);
    	$lmatch = $this->music->getLyrics($trackId);
    	$lfixed = str_replace(["\r\n", "\r", "\n"], "<br/>", $lmatch->message->body->lyrics->lyrics_body);
    	return view('lists.lyrics')->with(['data' => $lfixed]);
    }
}

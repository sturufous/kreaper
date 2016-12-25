<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
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
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$bmatch = $this->music->getTopTen();
		
		return view('lists.topten')->with(['data' => $bmatch, 'controller' => $this]);
	}
	
	public function getBandImage($mbid)
	{
		$bimage = "/images/blank.png";
		$bmatch = null;
		$repo = new FantvImageRepository();
		if($mbid != '')
		{
			$bmatch = $this->images->findArtist($mbid);
		}
		
		if($bmatch != null && isset($bmatch->artistbackground))
		{
			$bimage = $bmatch->artistbackground[0]->url;
		}
		
		return $bimage;
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
     * Search for a band in the repository.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function bandList(Request $request)
    {
		$repo = new MusixmatchMusicRepository();
		$bandName = $request->input('bandname');
		$bmatch = $this->music->findArtist($bandName);
        return view('lists.bandlist')->with(['data' => $bmatch, 'band' => $bandName]);
    }
    
    public function albumList(Request $request, $artistId)
    {
    	$repo = new MusixmatchMusicRepository();
    	$lmatch = $this->music->findAlbums($artistId);
    	return view('lists.albumlist')->with(['data' => $lmatch]);
    }
    
    public function trackList(Request $request, $albumId)
    {
    	$repo = new MusixmatchMusicRepository();
    	$tmatch = $this->music->findTracks($albumId);
    	return view('lists.tracklist')->with(['data' => $tmatch]);
    }
    
    public function getLyrics(Request $request, $trackId)
    {
    	$repo = new MusixmatchMusicRepository();
    	$lmatch = $this->music->getLyrics($trackId);
    	$lfixed = str_replace(["\r\n", "\r", "\n"], "<br/>", $lmatch->message->body->lyrics->lyrics_body);
    	return view('lists.lyrics')->with(['data' => $lfixed]);
    }
}

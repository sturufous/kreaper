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
	 * Show the application dashboard.
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
     * Search for a band in the repository.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function bandList(Request $request)
    {
		$bandName = $request->input('bandname');
		$bmatch = $this->music->findArtist($bandName);
        return view('lists.bandlist')->with(['data' => $bmatch, 'band' => $bandName]);
    }
    
    public function albumList(Request $request, $artistId)
    {
    	$artist = $this->music->getArtist($artistId);
    	$request->session()->put('artist_name', $artist->message->body->artist->artist_name);
    	$lmatch = $this->music->findAlbums($artistId);
    	return view('lists.albumlist')->with(['data' => $lmatch]);
    }
    
    public function trackList(Request $request, $albumId)
    {
    	$tmatch = $this->music->findTracks($albumId);
    	return view('lists.tracklist')->with(['data' => $tmatch]);
    }
    
    public function getLyrics(Request $request, $trackId)
    {
    	$lmatch = $this->music->getLyrics($trackId);
    	$lfixed = str_replace(["\r\n", "\r", "\n"], "<br/>", $lmatch->message->body->lyrics->lyrics_body);
    	return view('lists.lyrics')->with(['data' => $lfixed]);
    }
}

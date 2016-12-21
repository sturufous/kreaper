<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Storage\MusixmatchMusicRepository;
use Storage\MusicRepository as Music;

class HomeController extends Controller
{
	private $music;
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct(Music $music)
	{
		$this->music = $music;
        $this->middleware('auth');
	}
	
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('home');
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
    
    public function extractAlbums(Request $request, $artistId)
    {
    	$repo = new MusixmatchMusicRepository();
    	$lmatch = $this->music->findAlbums($artistId);
    	return view('lists.albumlist')->with(['data' => $lmatch]);
    }
}

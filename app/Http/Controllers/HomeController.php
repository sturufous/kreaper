<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Storage\MusixmatchMusicRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$repo = new MusixmatchMusicRepository();
		$bmatch = $repo->find('Rush');
    	//dump($jsonObj);
        return view('home')->with(['data' => $bmatch]);
    }
}

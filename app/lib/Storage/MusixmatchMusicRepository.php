<?php
namespace Storage;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

define('MUSIXMATCH_BASE_URL','http://api.musixmatch.com/ws/1.1/');
define('MUSIXMATHC_API_KEY', '5267dd058c1449820f5f2c119b88c8b8');

class MusixmatchMusicRepository implements MusicRepository {
	
	private function invoke($method, $apiFunction, $args)
	{
		$client = new Client(); //GuzzleHttp\Client
		$args['apikey'] = MUSIXMATHC_API_KEY;
		$result = $client->request($method, 
			MUSIXMATCH_BASE_URL.$apiFunction, 
			[
				'query' => $args
			]
		);
		
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
	
	public function findArtist($artistName)
	{
		$jsonObj = $this->invoke('GET', 'artist.search', [
						'page_size' => '100',
						'q_artist' => $artistName
				]
		);
		
		return $jsonObj;
	}
	
	public function findAlbums($artistId)
	{
		$jsonObj = $this->invoke('GET', 'artist.albums.get', [
				'page_size' => '100',
				'artist_id' => $artistId,
				'g_album_name' => '1',
				's_release_date' => 'asc'
			]
		);
		
		return $jsonObj;
	}
	
	public function findTracks($albumId)
	{
		$jsonObj = $this->invoke('GET', 'album.tracks.get', [
				'page_size' => '100',
				'album_id' => $albumId,
				'f_has_lyrics' => 'yes'
			]
		);
	
		return $jsonObj;
	}
	
	public function getLyrics($trackId)
	{
		$jsonObj = $this->invoke('GET', 'track.lyrics.get', [
				'track_id' => $trackId
			]
		);
	
		return $jsonObj;
	}
	
	public function getTopTen()
	{
		$jsonObj = $this->invoke('GET', 'chart.artists.get', [
				'page_size' => '10',
				'country' => 'ca'
			]
		);
	
		return $jsonObj;
	}
}
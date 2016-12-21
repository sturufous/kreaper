<?php
namespace Storage;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class MusixmatchMusicRepository implements MusicRepository {

	public function findArtist($artistName)
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->request('GET', 'http://api.musixmatch.com/ws/1.1/artist.search', [
				'query' => ['apikey' => '5267dd058c1449820f5f2c119b88c8b8',
						'page_size' => '200',
						'q_artist' => $artistName
				]
		]);
		
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
	
	public function findAlbums($artistId)
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->request('GET', 'http://api.musixmatch.com/ws/1.1/artist.albums.get', [
				'query' => ['apikey' => '5267dd058c1449820f5f2c119b88c8b8',
						'page_size' => '200',
						'artist_id' => $artistId,
						'g_album_name' => '1',
						's_release_date' => 'asc'
				]
		]);
		
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
}
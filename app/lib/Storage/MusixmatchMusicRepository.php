<?php
namespace Storage;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

define('MUSIXMATCH_BASE_URL','http://api.musixmatch.com/ws/1.1/');

class MusixmatchMusicRepository implements MusicRepository {
	
	
	public function findArtist($artistName)
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->request('GET', MUSIXMATCH_BASE_URL.'artist.search', [
				'query' => ['apikey' => '5267dd058c1449820f5f2c119b88c8b8',
						'page_size' => '100',
						'q_artist' => $artistName
				]
		]);
		
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
	
	public function findAlbums($artistId)
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->request('GET', MUSIXMATCH_BASE_URL.'artist.albums.get', [
				'query' => ['apikey' => '5267dd058c1449820f5f2c119b88c8b8',
						'page_size' => '100',
						'artist_id' => $artistId,
						'g_album_name' => '1',
						's_release_date' => 'asc'
				]
		]);
		
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
	
	public function findTracks($albumId)
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->request('GET', MUSIXMATCH_BASE_URL.'album.tracks.get', [
				'query' => ['apikey' => '5267dd058c1449820f5f2c119b88c8b8',
						'page_size' => '100',
						'album_id' => $albumId,
						'f_has_lyrics' => 'yes'
				]
		]);
	
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
	
	public function getLyrics($trackId)
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->request('GET', MUSIXMATCH_BASE_URL.'track.lyrics.get', [
				'query' => ['apikey' => '5267dd058c1449820f5f2c119b88c8b8',
						'track_id' => $trackId
				]
		]);
	
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
}
<?php
namespace Storage;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class MusixmatchMusicRepository implements MusicRepository {

	public function find($id)
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->request('GET', 'http://api.musixmatch.com/ws/1.1/artist.search', [
				'query' => ['apikey' => '5267dd058c1449820f5f2c119b88c8b8',
						'page_size' => '200',
						'q_artist' => $id]
		]);
		$jsonObj = json_decode($result->getBody());
		return $jsonObj;
	}
}
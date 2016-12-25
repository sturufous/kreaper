<?php
namespace Storage;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

define('FANTV_BASE_URL','http://webservice.fanart.tv/v3/music/');
define('FANTV_API_KEY', '6abd83073a4f27f45859311709196f40');

class FantvImageRepository implements ImageRepository {
	
	private function invoke($method, $apiFunction, $args)
	{
		$args['api_key'] = FANTV_API_KEY;
		try 
		{
			$client = new Client(['base_uri' => FANTV_BASE_URL], [
				'request.options' => ['http_errors' => false]
			]);
					
			$result = $client->request($method, 
				FANTV_BASE_URL.$apiFunction, 
				[
					'query' => $args
				]
			);
			$jsonObj = json_decode($result->getBody());
		}
		catch (Exception $e)
		{
			$jsonObj = null;
		}
		
		return $jsonObj;
	}
	
	public function findArtist($mbid)
	{
		try 
		{
			$jsonObj = $this->invoke('GET', $mbid, []);
			return $jsonObj;
		}
		catch (Exception $e)
		{
			return null;
		}
	}
}
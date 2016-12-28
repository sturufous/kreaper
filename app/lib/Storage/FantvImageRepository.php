<?php
namespace Storage;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

const FANTV_BASE_URL = 'http://webservice.fanart.tv/v3/music/';
const FANTV_API_KEY = '6abd83073a4f27f45859311709196f40';
const FANTV_IMAGE_DIR = '/home/vagrant/kreaper/public/images/bands/';

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
	
	public function saveImageLocal($imageUrl, $mbid)
	{
		try
		{
			if($imageUrl == '/images/blank.png')
			{
				copy(FANTV_IMAGE_DIR.'blank.jpg', FANTV_IMAGE_DIR.$mbid.'.jpg');
			}
			else
			{
				$path_parts = pathinfo($imageUrl);
				$ext = strtolower($path_parts["extension"]);
				
				$client = new Client();
				$response = $client->request('GET', $imageUrl, ['connect_timeout' => 10]);
				if ($this->isGoodResponse($response)) 
				{
					$this->saveBandImage($mbid, $ext, $response);
				}
				else
				{
					copy(FANTV_IMAGE_DIR.'blank.jpg', FANTV_IMAGE_DIR.$mbid.'.jpg');
				}
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function saveBandImage($mbid, $ext, $response)
	{
		$fileName = FANTV_IMAGE_DIR.$mbid.'.'.$ext;
		if(!file_exists($fileName))
		{
			file_put_contents(FANTV_IMAGE_DIR.$mbid.'.'.$ext, $response->getBody());
		}
	}
	
	public function isGoodResponse($response)
	{
		return $response->getBody()->isReadable() && $response->getStatusCode()==200;
	}
}
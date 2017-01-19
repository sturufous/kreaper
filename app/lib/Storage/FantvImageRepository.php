<?php
namespace Storage;

/**
 * Repository pattern class that provides access to the FanartTV API. This accesses
 * information about an Artist, but the only infomation used currently is the picture of the
 * band. 
 */

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

const FANTV_BASE_URL = 'http://webservice.fanart.tv/v3/music/';
const FANTV_API_KEY = '6abd83073a4f27f45859311709196f40';
const FANTV_IMAGE_DIR = '/home/vagrant/kreaper/public/images/bands/';

class FantvImageRepository implements ImageRepository {
	
/**
 * Invoke the FanTV API function identified by the $apiFunction argument.
 *
 * @param $method The HTTP method to use for the API call
 * @param $apiFunction The API function string for the current call
 * @param $args The query string arguments to send to the API
 * @return a JSON object retrieved from the API
 */
	
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
	
/**
 * Retrieve the artist in the FanTV database that matches the MusicBrainz ID
 *
 * @param $mbid The MusicBrainz id for the artist
 * @see \Storage\MusicRepository::findArtist()
 * @return Data regarding the artist in JSON format
 */
	
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
	
/**
 * Saves the image for the artist identified by $mbid to local storage.
 * 
 * @param $imageUrl The default image URL
 * @param $mbid The MusicBrainz ID of the artist being queried
 * @see \Storage\ImageRepository::saveImageLocal()
 */
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
				
				// Create a new Guzzle client for use in retrieving the image URL
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
	
/**
 * Save an artist image to the FanTV image directory.
 * 
 * @param $mbid MusicBrainz ID for the artist, used as the file name
 * @param $ext File extension of the image
 * @param $response The data passed back from the FanTV API in JSON format
 */
	
	public function saveBandImage($mbid, $ext, $response)
	{
		$fileName = FANTV_IMAGE_DIR.$mbid.'.'.$ext;
		if(!file_exists($fileName))
		{
			file_put_contents(FANTV_IMAGE_DIR.$mbid.'.'.$ext, $response->getBody());
		}
	}
	
/**
 * Checks the response to see if it is valid.
 * 
 * @param $response The response to be evaluated
 * @return boolean The validity of the response
 */
	
	public function isGoodResponse($response)
	{
		return $response->getBody()->isReadable() && $response->getStatusCode()==200;
	}
}
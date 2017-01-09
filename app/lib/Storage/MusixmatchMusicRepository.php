<?php
namespace Storage;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\MSDBSongs;

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
	
	public function getArtist($artistId)
	{
		$jsonObj = $this->invoke('GET', 'artist.get', [
				'artist_id' => $artistId
			]
		);
	
		return $jsonObj;
	}
	
	public function getAlbum($albumId)
	{
		$jsonObj = $this->invoke('GET', 'album.get', [
				'album_id' => $albumId
			]
		);
	
		return $jsonObj;
	}
	
	public function findAlbums($artistId)
	{
		$jsonObj = $this->invoke('GET', 'artist.albums.get', [
				'page_size' => '1000',
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
	
	public function getTrack($trackId)
	{
		$jsonObj = $this->invoke('GET', 'track.get', [
				'track_id' => $trackId
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
	
	public function isArtistInMSDB($artistMbid)
	{
		if($artistMbid != '')
		{
			$artist = new MSDBSongs();
			$matching = $artist->where('artist_mbid', $artistMbid)->get()->count();
			return $matching > 0 ? true : false;
		}
		else 
		{
			return false;
		}
	}
	
	/**
	 * 
	 * @param $artist_mbid Artist ID
	 * @param $release The name of the album
	 * @return boolean
	 */
	
	public function isAlbumInMSDB($artistMbid, $release)
	{
		if($artistMbid != '' && $release != '')
		{
			$repo = new MSDBSongs();
			$matching = $repo->where('artist_mbid', $artistMbid)->where('release', $release)->get()->count();
			return $matching > 0 ? true : false;
		}
		else
		{
			return false;
		}
	}
	/**
	 *
	 * @param $artist_mbid Artist ID
	 * @param $release The name of the album
	 * @return boolean
	 */
	
	public function isTrackInMSDB($artistMbid, $trackName)
	{
		if($artistMbid != '' && $trackName != '')
		{
			$songs = new MSDBSongs();
			$matching = $songs->where('artist_mbid', $artistMbid)->where('title', $trackName)->get()->count();
			return $matching > 0 ? true : false;
		}
		else
		{
			return false;
		}
	}
	
	public function getMSDBSong($artistMbid, $trackName)
	{
		if($artistMbid != '' && $trackName != '')
		{
			$songs = new MSDBSongs();
			$matching = $songs->where('artist_mbid', $artistMbid)->where('title', $trackName)->first();
			return $matching;
		}
		else
		{
			return false;
		}
	}
}
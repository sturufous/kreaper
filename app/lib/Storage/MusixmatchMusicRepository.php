<?php
namespace Storage;

/**
 * Repository pattern class that provides access to the Musixmatch API. This accesses
 * information about an Artist, their albums, tracks and lyrics. As this project works
 * with the Million Song Database from Columbia University, the data is sometimes filtered.
 * There are also instances where data from both the Musixmatch API and the MSDB are used.
 */

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\MSDBSongs;

const MUSIXMATCH_BASE_URL = 'http://api.musixmatch.com/ws/1.1/';
const MUSIXMATHC_API_KEY = '5267dd058c1449820f5f2c119b88c8b8';

class MusixmatchMusicRepository implements MusicRepository {
	
/**
 * Invoke the Musixmatch API function identified by the $apiFunction argument.
 * 
 * @param $method The HTTP method to use for the API call
 * @param $apiFunction The API function string for the current call
 * @param $args The query string arguments to send to the API
 * @return a JSON object retrieved from the API
 */
	
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
	
/**
 * Do a string based search for artists in the Musixmatch database with names that contain
 * the string $artistName.
 * 
 * @param $artistName A string matching part or all of an artist name
 * @see \Storage\MusicRepository::findArtist()
 * @return The list of matching artists in JSON format
 */
	
	public function findArtist($artistName)
	{
		$jsonObj = $this->invoke('GET', 'artist.search', [
				'page_size' => '100',
				'q_artist' => $artistName
			]
		);
		
		return $jsonObj;
	}
	
/**
 * Get information from the Musixmatch API regarding the artist identified by $artistId.
 * 
 * @param $artistId The Musixmatch artist ID 
 * @see \Storage\MusicRepository::getArtist()
 * @return The artist information in JSON format
 */
	
	public function getArtist($artistId)
	{
		$jsonObj = $this->invoke('GET', 'artist.get', [
				'artist_id' => $artistId
			]
		);
	
		return $jsonObj;
	}

/**
 * Get information from the Musixmatch API regarding the album identified by $albumId.
 * 
 * @param $albumId The Musixmatch albumId
 * @see \Storage\MusicRepository::getAlbum()
 * @return The album information in JSON format
 */
	
	public function getAlbum($albumId)
	{
		$jsonObj = $this->invoke('GET', 'album.get', [
				'album_id' => $albumId
			]
		);
	
		return $jsonObj;
	}
	
/**
 * Get a list of albums from the Musixmatch API that match the artist $artistId.
 * 
 * @param $artistId The Musixmatch Artist ID
 * @see \Storage\MusicRepository::findAlbums()
 * @return The list of albums in JSON format
 */
	
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
/**
 * Get a list of tracks from the Musixmatch API that match the album $albumId.
 * 
 * @see \Storage\MusicRepository::findTracks()
 * @param $albumId The Musixmatch albumId
 * @return the list of tracks in JSON format
 */
	
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
	
/**
 * Get information from the Musixmatch API regarding the track identified by $trackId.
 * 
 * @see \Storage\MusicRepository::getTrack()
 * @param $trackId The Musixmatch trackId
 * @return track information in JSON format
 */
	
	public function getTrack($trackId)
	{
		$jsonObj = $this->invoke('GET', 'track.get', [
				'track_id' => $trackId
			]
		);
	
		return $jsonObj;
	}
	
/**
 * Get lyrics from the Musixmatch API for the track identified by $trackId.
 *
 * @see \Storage\MusicRepository::getLyrics()
 * @param $trackId The Musixmatch trackId
 * @return The lyrics in JSON format
 */
	
	public function getLyrics($trackId)
	{
		$jsonObj = $this->invoke('GET', 'track.lyrics.get', [
				'track_id' => $trackId
			]
		);
	
		return $jsonObj;
	}
/**
 * Get information regarding the ten most popular artists (at this time) from Musixmatch.
 * 
 * @see \Storage\MusicRepository::getTopTen()
 * @return Information regarding the top ten artists in JSON format
 */
	
	public function getTopTen()
	{
		$jsonObj = $this->invoke('GET', 'chart.artists.get', [
				'page_size' => '10',
				'country' => 'ca'
			]
		);
	
		return $jsonObj;
	}
	
/**
 * Given a MusicBrainz ID this function determines if this artist is represented in the MSDB.
 * 
 * @param $artistMbid The MusicBrainz ID for the artist being assessed
 * @see \Storage\MusicRepository::isArtistInMSDB()
 * @return Boolean indicating whether the Artist is represented in the MSDB
 */	
	
	public function isArtistInMSDB($artistMbid)
	{
		if($artistMbid != '')
		{
			// Create an instance of the MSDB model
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
 * Given a MusicBrainz ID and album name this function determines if this album is represented in the MSDB.
 *
 * @param $artistMbid The MusicBrainz ID for the artist being assessed
 * @param $release The name of the album being assessed
 * @see \Storage\MusicRepository::isAlbumInMSDB()
 * @return Boolean indicating whether the Album is represented in the MSDB
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
 * Given an artist name and track name this function determines if this track is represented in the MSDB.
 *
 * @param $artistName The name of the artist
 * @param trackName The name of the track
 * @see \Storage\MusicRepository::isTrackInMSDB()
 * @return Boolean indicating whether the track is represented in the MSDB
 */
	
	public function isTrackInMSDB($artistName, $trackName)
	{
		if($artistName != '' && $trackName != '')
		{
			$songs = new MSDBSongs();
			$matching = $songs->where('artist_name', $artistName)->where('title', $trackName)->get()->count();
			return $matching > 0 ? true : false;
		}
		else
		{
			return false;
		}
	}
	
/**
 * Given a MusicBrainz ID and track name this function retrieves the song from the MSDB.
 *
 * @param $artistMbid The MusicBrainz ID of the artist
 * @param $trackName The name of the track being retrieved
 * @see \Storage\MusicRepository::getMSDBSong()
 */	
	
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
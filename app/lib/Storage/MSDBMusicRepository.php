<?php
namespace Storage;

/**
 * Repository pattern class that provides access to the Musixmatch API. This accesses
 * information about an Artist, their albums, tracks and lyrics. As this project works
 * with the Million Song Database from Columbia University, the data is sometimes filtered.
 * There are also instances where data from both the Musixmatch API and the MSDB are used.
 */

use App\MSDBSongs;

class MSDBMusicRepository implements MSDBRepository {
		
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
		return true;
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
	
	/**
	 * Given an artist name and track name this function determines if this track is represented in
	 * the MSDB Lyrics file.
	 *
	 * @param $artistName The name of the artist
	 * @param trackName The name of the track
	 * @see \Storage\MusicRepository::getTrackEchonest()
	 * @return Boolean indicating whether the track is represented in the MSDB
	 */
	
	public function doesTrackHaveMSDBLyrics($artistName, $trackName)
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
}
<?php
namespace Storage;

interface MSDBRepository {
	 
	public function findArtist($artistName);
	public function isArtistInMSDB($artistId);
	public function isAlbumInMSDB($artistMBID, $release);
	public function isTrackInMSDB($artistMBID, $trackName);
	public function getMSDBSong($artistName, $trackName);
	public function doesTrackHaveMSDBLyrics($artistName, $trackName);
}
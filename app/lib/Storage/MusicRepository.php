<?php
namespace Storage;

interface MusicRepository {
	 
	public function findArtist($artistName);
	public function findAlbums($artistId);
	public function findTracks($trackId);
	public function getTopTen();
	public function getArtist($artistId);
	public function isArtistInMSDB($artistId);
	public function getAlbum($albumId);
	public function isAlbumInMSDB($artistMBID, $release);
	public function getTrack($trackId);
	public function isTrackInMSDB($artistMBID, $trackName);
	public function getMSDBSong($artistName, $trackName);
	public function doesTrackHaveMSDBLyrics($artistName, $trackName);
}
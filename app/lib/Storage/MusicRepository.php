<?php
namespace Storage;

interface MusicRepository {
	 
	public function findArtist($artistName);
	public function findAlbums($artistId);
	public function findTracks($trackId);
	public function getTopTen();
	public function getArtist($artistId);
	public function getAlbum($albumId);
	public function getTrack($trackId);
}
<?php
namespace Storage;

interface MusicRepository {
	 
	public function findArtist($artistName);
	public function findAlbums($artistId);
	public function findTracks($trackId);
	
}
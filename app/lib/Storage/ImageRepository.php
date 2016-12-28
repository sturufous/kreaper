<?php
namespace Storage;

interface ImageRepository {
	 
	public function findArtist($mbid);
	public function saveImageLocal($path, $mbid);
	
}
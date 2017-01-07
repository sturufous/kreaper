<?php

use Storage\ImageRepository as Images;
use Storage\FantvImageRepository;

function flash($label, $level='info') 
{
	Session::flash($label, 'Hello Stu!');
}

function getBandImage($images, $mbid)
{
	$bimage = "/images/blank.png";
	$bmatch = null;
	if($mbid != '')
	{
		$bmatch = $images->findArtist($mbid);
	}

	if($bmatch != null && isset($bmatch->artistbackground))
	{
		$bimage = $bmatch->artistbackground[0]->url;
	}

	return $bimage;
}

/**
 * Displays stars representing the Musixmatch artist_rating for this artist.
 * 
 * @param $band Band object from Musixmatch API
 */

function showGlyphs($band)
{
	$rating = $band->artist->artist_rating/10;
	for($idx=0; $idx<$rating; $idx++)
	{
		echo '<span class="glyphicon glyphicon-star"></span>';	
	}
}

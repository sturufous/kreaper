<?php

use Storage\ImageRepository as Images;
use Storage\FantvImageRepository;

/**
 * Prototype for using the sessions flash() capability to display a message
 * only once after a particular action has been taken.
 * 
 * @param  $label The name of the variable in the session
 * @param  $level The level of the message to be flashed
 */

function flash($label, $level='info') 
{
	Session::flash($label, 'Content');
}

/**
 * Get an image for the band/artist from the Fantv repository.
 * 
 * @param $images FanTV repository instance
 * @param $mbid MusicBrainz ID for the current artist
 * @return string
 */

function getBandImage($images, $mbid)
{
	// Default the band image to blank. It's likely Fantv has no image for
	// the band or the Musixmatch mbid passed is blank.
	$bimage = "/images/blank.png";
	$bmatch = null;
	
	if($mbid != '')
	{
		$bmatch = $images->findArtist($mbid);
	}

	// If the artist is found and has a background picture assign to $bimage
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

/**
 * Uses the BootStrap progress-bar to display the rating for the current track.
 * 
 * @param $level The rating of the track, currently between 1 and 100
 * @param unknown $max The maximum value of rating (not used currently)
 */

function showRating($level, $max)
{
	$green = $level <= 50 ? $level : 50;
	$red = $level > 75 ? $level - 75 : 0;
	$yellow = $level > 50 && $level <= 75 ? $level - 50 : (25 * ($red > 0));

	echo '<div class="progress" style="width:100px">';
	echo '<div class="progress-bar progress-bar-success" role="progressbar" style="width:' . $green . '%"></div>';
	if($yellow)
	{
		echo '<div class="progress-bar progress-bar-warning" role="progressbar" style="width:' . $yellow . '%"></div>';
	}
	if($red)
	{
		echo '<div class="progress-bar progress-bar-danger" role="progressbar" style="width:' . $red . '%"></div>';
	}
	echo '</div>';
}
	
/**
 * Displays the type of the ablum (Single, Crowd, Compilation etc.). This helper was created
 * to allow the use of a glyph but this hasn't been implemented yet.
 * 
 * @param  $type A string representing the album type.
 * @return string The padded album type
 */

function showAlbumType($type)
{
	return $type . '&nbsp;&nbsp;&nbsp;';
}
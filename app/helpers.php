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

function showRating($level, $max)
{
	$green = $level <= 50 ? $level : 50;
	$red = $level > 75 ? $level - 75 : 0;
	$yellow = $level > 50 && $level <= 75 ? $level - 50 : (25 * ($red > 0));

	if($level)
	{
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
}
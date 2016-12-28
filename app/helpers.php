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
	$repo = new FantvImageRepository();
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

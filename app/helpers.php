<?php

use Storage\ImageRepository as Images;
use Storage\FantvImageRepository;

define("STOP_WORDS","|i|me|my|myself|we|us|our|ours|ourselves|you|your|yours|yourself|yourselves|he|him|his|himself|she|her|hers|herself|it|its|itself|they|them|their|theirs|themselves|what|which|who|whom|whose|this|that|these|those|am|is|are|was|were|be|been|being|have|has|had|having|do|does|did|doing|will|would|should|can|could|ought|i'm|you're|he's|she's|it's|we're|they're|i've|you've|we've|they've|i'd|you'd|he'd|she'd|we'd|they'd|i'll|you'll|he'll|she'll|we'll|they'll|isn't|aren't|wasn't|weren't|hasn't|haven't|hadn't|doesn't|don't|didn't|won't|wouldn't|shan't|shouldn't|can't|cannot|couldn't|mustn't|let's|that's|who's|what's|here's|there's|when's|where's|why's|how's|a|an|the|and|but|if|or|because|as|until|while|of|at|by|for|with|about|against|between|into|through|during|before|after|above|below|to|from|up|upon|down|in|out|on|off|over|under|again|further|then|once|here|there|when|where|why|how|all|any|both|each|few|more|most|other|some|such|no|nor|not|only|own|same|so|than|too|very|say|says|said|shall|");

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

/**
 * Get the word counts for the current track and generate a document for display.
 * Each line of the document will contain a single word repeated by the number of times
 * it appears in the track. This will be interpreted by the word cloud software as if
 * it were processing the lyrics of the song itself. The difference is that the lyrics
 * in the MSDB are stemmed words.
 * 
 * @param $request The current HTTP request
 * @return string A document created dynamically for display as a Word Cloud
 */

function lyricsFromWordCounts($request)
{
	$wordCounts = $request->session()->get('word_counts');
	$lyrics = '';
	
	// For each word used in the track, create individual lines containing that word
	// repeated by the number of times it appears in the track
	foreach($wordCounts as $word)
	{
		for($idx=0;$idx<$word->count;$idx++)
		{
			$lyrics .= $word->word . ' ';
		}
		$lyrics .= "\n";
	}
	
	return $lyrics;
}

/**
 * Used to filter out words that are of little consequence to sentiment/tone analysis.
 * 
 * @param $word The word to check against the STOP_WORDS constant.
 * @return whether the word is a stop word or not (true/false)
 */

function isStopWord($word)
{
	$needle = '|' . strtolower($word) . '|';
	$position = strpos(STOP_WORDS, $needle);
	return $position === false ? false : true;
}
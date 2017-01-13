<?php
namespace Storage;

use Illuminate\Support\ServiceProvider;

/**
 * Register service providers for the Musixmatch and FanTV APIs
 * 
 * @author stuartmorse
 */

class StorageServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'Storage\MusicRepository',
			'Storage\MusixmatchMusicRepository'
		);
		
		$this->app->bind(
			'Storage\ImageRepository',
			'Storage\FantvImageRepository'
		);
	}
}
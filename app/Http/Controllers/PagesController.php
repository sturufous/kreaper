<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Session;
use App;

class StuClass {
	
}

class PagesController extends BaseController
{
	function home() {
		//App::singleton('blage', function() {
		//	return new StuClass();
		//});
		
		//$test = App::make('blage');
		//$test2 = App::make('blage');
				
		return view('home');
	}
	
	function about() {
		
		$people = ['Deb','Stuart','Aliyah'];
		
		return view('about', compact('people'));
	}
	
}

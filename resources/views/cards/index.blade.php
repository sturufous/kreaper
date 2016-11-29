 @extends('layout')
 
 @section('content')
    <div class="content">
        <div class="row">
        	<div class="col-md-6 col-md-offset-3">
	        	<ul class="list-group">
    			<h1>All Cards</h1>
	            @foreach ($cards as $card)
	                <a href="/cards/{{ $card->id }}"class="list-group-item">{{ $card->title }}</a>
	            @endforeach
	        </div>
	    </div>
    </div>
@stop
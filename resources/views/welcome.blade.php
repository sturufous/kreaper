@extends('layout')

@section('content')
   <div class="content">
        <div class="row">
        	<div class="col-md-6 col-md-offset-3">
        	@if(Session::has('status'))
        		<h3>{{ Session::get('status') }}</h3>
        	@endif
				<h1>This is the welcome page</h1>
							
				<ul class="list-group">
					<a class="list-group-item" href="/cards">Search Bands by name</a>
				</ul>
				
			</div>
		</div>
	</div>
@stop

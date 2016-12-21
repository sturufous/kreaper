@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Lyrics for this track</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
                        <li>
                        	{!! $data !!}
                        </li>
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

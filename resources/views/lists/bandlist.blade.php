@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Bands that match: {{ $band }}</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
				        @foreach ($data->message->body->artist_list as $band)
                            <li><a href="/extract/{{ $band->artist->artist_id }}" class="list-group-item" style="margin-right:20px;margin-left:20px">{{ $band->artist->artist_name }} <span class="pull-right">{{$band->artist->artist_id}}</span></a></li>
			            @endforeach
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

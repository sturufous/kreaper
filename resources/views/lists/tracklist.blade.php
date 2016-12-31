@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Tracks for this album</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
@foreach ($data->message->body->track_list as $tracks)
                            <a href="/showlyrics/{{ $tracks->track->track_id }}" class="list-group-item" style="margin-right:20px;margin-left:20px">{{ $tracks->track->track_name }} <span class="pull-right">{{$tracks->track->track_rating}}</span></a>
@endforeach
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Albums for {{ Request::session()->get('artist_name') }} (Total: {{ $data->message->header->available }})</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
@foreach ($data->message->body->album_list as $album)
                            <a href="/tracklist/{{ $album->album->album_id }}" class="list-group-item" style="margin-right:20px;margin-left:20px">{{ $album->album->album_name }} <span class="pull-right">{{$album->album->album_release_type}}</span></a>
@endforeach
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

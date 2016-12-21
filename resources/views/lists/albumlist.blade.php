@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Albums for this band (Total: {{ $data->message->header->available }})</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
				        @foreach ($data->message->body->album_list as $album)
                            <li><a href="/tracklist/{{ $album->album->album_id }}" class="list-group-item" style="margin-right:20px;margin-left:20px">{{ $album->album->album_name }} <span class="pull-right">{{$album->album->album_release_type}}</span></a></li>
			            @endforeach
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

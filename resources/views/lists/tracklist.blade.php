@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Matched: {{ Request::session()->get('artist_match') }}</li>
  <li class="breadcrumb-item"><a href="/albumlist/{{ Request::session()->get('artist_id') }}">{{ Request::session()->get('artist_name') }}</a></li>
  <li class="breadcrumb-item active">{{ Request::session()->get('album_name') }}</li>
</ol>

<div class="container">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>{{ Request::session()->get('album_name') }}</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
@foreach ($data as $track)
                            <a href="/showlyrics/{{ $track->track->track_id }}" class="list-group-item" style="margin-right:20px;margin-left:20px">{{ $track->track->track_name }} <span class="pull-right">{{ showRating($track->track->track_rating, 100) }}</span></a>
@endforeach
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

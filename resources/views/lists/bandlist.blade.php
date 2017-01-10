@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Matched: {{ $band }}</li>
</ol>

<div class="container">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Bands that match: {{ $band }}</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
@foreach ($data as $band)
                            <a href="/albumlist/{{ $band->artist->artist_id }}" class="list-group-item" style="margin-right:20px;margin-left:20px" alt="{{ $band->artist->artist_mbid }}">{{ $band->artist->artist_name }} <span class="pull-right">{{$band->artist->artist_id}}</span></a>
@endforeach
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

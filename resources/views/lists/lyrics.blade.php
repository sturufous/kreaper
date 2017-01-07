@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>{{ Request::session()->get('track_name') }}</h2>
                </div>
		        <div>
					<ul class="list-unstyled">
                        <li style="padding-left:20px">
                        	{!! $data !!}
                        </li>
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
@stop

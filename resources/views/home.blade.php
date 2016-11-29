@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
					<h2>This is the welcome page</h2>
					<ul class="list-group">
						<a class="list-group-item" href="/cards">List my Cards</a>
					</ul>
	
                <div class="panel-body">
                    You are logged in!
                </div>
				{{ dump(Auth::user()) }}
            </div>
        </div>
    </div>
</div>
@endsection

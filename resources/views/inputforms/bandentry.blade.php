@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:20px">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Search bands by name</h2></div>
				<div class="panel-heading">
					<form method="POST" action="/bandlist">
						{{ csrf_field() }}
						<ul class="list-group">
							Which band should we get lyrics for? 
						</ul>
						<div class="form-group">
							<input name="bandname" class="form-control">{{ old('bandname') }}</input>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Find Band</button>
						</div>
					</form>
				</div>
	        </div>
        </div>
    </div>
</div>
@endsection

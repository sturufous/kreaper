@extends('layout')
 
@section('content')

   <div class="content">
        <div class="row">
        	<div class="col-md-6 col-md-offset-3">
				<ul class="list-group">
					<h1>{{ $card->title }}</h1>
					@foreach ($card->notes as $note)
						<a href="/notes/{{ $note->id }}/edit" class="list-group-item">{{ $note->body }} <span class="pull-right">{{$note->user->username}}</span></a>
					@endforeach
				</ul>
				
				<h3>Create a new note</h3>
				
				<form method="POST" action="/cards/{{ $card->id }}/notes">
					{{ csrf_field() }}
					<div class="form-group">
						<textarea name="body" class="form-control">{{ old('body') }}</textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Add Note</button>
					</div>
				</form>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
				</pre>
			</div>
		</div>
	</div>
@stop

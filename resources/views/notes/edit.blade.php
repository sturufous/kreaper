@extends('layout')
 
@section('content')

   <div class="content">
        <div class="row">
        	<div class="col-md-6 col-md-offset-3">
				<ul class="list-group">
					<h1>Edit the note</h1>
                </ul>				
				<form method="POST" action="/notes/{{ $note->id }}">
					{{ method_field("PATCH") }}
					{{ csrf_field() }}
					<div class="form-group">
						<textarea name="body" class="form-control">{{ $note->body }}</textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Update Note</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop

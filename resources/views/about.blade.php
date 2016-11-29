 @extends('layout')
 
 @section('content')
    <div class="content">
        <div class="title m-b-md">
            @foreach ($people as $person)
                <li>{{ $person }}</li>
            @endforeach
            This is the about page
        </div>
    </div>
@stop
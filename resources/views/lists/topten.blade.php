@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            @include('layouts.sidenav')
            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="images/carousel1.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="images/carousel4.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="images/carousel3.jpg" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row">
@foreach ($data->message->body->artist_list as $band)
					<div class="col-sm-6 col-lg-6 col-md-6">
						<input type="hidden" value="{{ $band->artist->artist_mbid }}">
						<div class="thumbnail">
                            <img src="images/bands/{{ $band->artist->artist_mbid }}.jpg" alt="" style="width:332px; height:150px">
                            <div class="caption">
                                <h4><a target="_blank" href="{{ $band->artist->artist_share_url }}" target="_blank">{{ $band->artist->artist_name }}</a>
                                @if ($band->artist->artist_twitter_url != '')
                                	<a href="{{ $band->artist->artist_twitter_url }}" target="_blank">
    								    <img src="images/twitter.png" class="pull-right" style="width:30px; height:29px">
    								</a>
    							@else
  									<img src="images/twitter-grey.png" class="pull-right" style="width:30px; height:29px">  							
    							@endif
                                </h4>
                                <p>Genre: {{ $band->artist->primary_genres->music_genre_list[0]->music_genre->music_genre_name or 'Default'}}</a></p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">15 reviews</p>
                                <p>
                                	{{ showGlyphs($band) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                 </div>
            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Optimedia Solutions 2017</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

@stop

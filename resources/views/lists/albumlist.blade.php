@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li class="breadcrumb-item">Matched: {{ Request::session()->get('artist_match') }}</li>
  <li class="breadcrumb-item"><a href="/albumlist/{{ Request::session()->get('artist_id') }}">{{ Request::session()->get('artist_name') }}</a></li>
</ol>

<div class="container">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>Albums for {{ Request::session()->get('artist_name') }} (Total: {{ Request::session()->get('artist_album_count') }})</h2>
                </div>
                <div class="container">
                	<div class="row">
						<div class="col-md-4" id="chart-container">
							FusionCharts XT will load here!
						</div>
						<div class="col-md-5" id="blah-container">
							<img src="/images/flags/{{ strtolower(Request::session()->get('artist_country')) }}.svg" class="img-rounded" style="height:46px; margin-top:15px">
							@if (Request::session()->get('artist_twitter') != '')
                            	<a href="{{ Request::session()->get('artist_twitter') }}" target="_blank">
    								<img src="/images/twitter-l.png" style="width:50px; height:50px; margin-top:14px;margin-left:15px">
    							</a>
    						@else
  								<img src="/images/twitter-lgrey.png" style="width:50px; height:50px; margin-top:14px;margin-left:15px">  							
    						@endif
						</div>
					</div>
				</div>
		        <div>
					<ul class="list-unstyled">
@foreach ($data as $album)
                            <a href="/tracklist/{{ $album->album->album_id }}" class="list-group-item" style="margin-right:20px;margin-left:20px">{{ $album->album->album_name }} <span class="pull-right">{{ showRating($album->album->album_rating, 100) }}</span></a>
@endforeach
					</ul>
				</div>
	        </div>
        </div>
    </div>
</div>
<script type="text/javascript">
FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "chart-container",
        "width": "350",
        "height": "200",
        "dataFormat": "json",
        "dataSource":{
               "chart": {
                  "caption": "Artist Rating",
                  "subcaption": "Familiarity",
                  "lowerLimit": "0",
                  "upperLimit": "100",
                  "theme": "fint"
               },
               "colorRange": {
                  "color": [
                     {
                        "minValue": "0",
                        "maxValue": "50",
                        "code": "#6baa01"
                     },
                     {
                        "minValue": "50",
                        "maxValue": "75",
                        "code": "#f8bd19"
                     },
                     {
                        "minValue": "75",
                        "maxValue": "100",
                        "code": "#e44a00"
                     }
                  ]
               },
               "dials": {
                  "dial": [
                     {
                        "value": "{{ Request::session()->get('artist_rating') }}"
                     }
                  ]
               }
            }
      });

    csatGauge.render();
});
</script>
@stop

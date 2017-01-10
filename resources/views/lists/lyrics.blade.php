@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Matched: {{ Request::session()->get('artist_match') }}</li>
  <li class="breadcrumb-item"><a href="/albumlist/{{ Request::session()->get('artist_id') }}">{{ Request::session()->get('artist_name') }}</a></li>
  <li class="breadcrumb-item"><a href="/tracklist/{{ Request::session()->get('album_id') }}">{{ Request::session()->get('album_name') }}</a></li>
  <li class="breadcrumb-item active">{{ Request::session()->get('track_name') }}</li>
</ol>

<div class="container">
    <div class="row">
        @include('layouts.sidenav')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>{{ Request::session()->get('track_name') }}</h2>
                </div>
                <div class="container">
                	<div class="row">
						<div class="col-md-4" id="familiarity-container">
							{{ Request::session()->get('artist_familiarity') }}
						</div>
						<div class="col-md-4" id="hotttnesss-container">
							{{ Request::session()->get('artist_hotttnesss') }}
						</div>
					</div>
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
<script type="text/javascript">
FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "familiarity-container",
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
                        "value": "{{ Request::session()->get('artist_familiarity') }}"
                     }
                  ]
               }
            }
      });

    csatGauge.render();
});
FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "hotttnesss-container",
        "width": "350",
        "height": "200",
        "dataFormat": "json",
        "dataSource":{
               "chart": {
                  "caption": "Artist Rating",
                  "subcaption": "Hotness",
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
                        "value": "{{ Request::session()->get('artist_hotttnesss') }}"
                     }
                  ]
               }
            }
      });

    csatGauge.render();
});
</script>
@stop

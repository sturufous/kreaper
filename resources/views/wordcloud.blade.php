<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Word Cloud Generator</title>
<style>
body {
  font-family: "Helvetica Neue", sans-serif;
  width:100%;
  margin-bottom: 1em;
  margin-top: 20px;
  margin-left: 30px;
}
#presets a { border-left: solid #666 1px; padding: 0 10px; }
#presets a.first { border-left: none; }
#keyword { width: 300px; }
#fetcher { width: 500px; }
#keyword, #go { font-size: 1.5em; }
#text { width: 100%; height: 100px;}
p.copy { font-size: small; }
#form { font-size: small; position: relative; margin-left:30px; margin-right:30px}
hr { border: none; border-bottom: solid #ccc 1px; }
a.active { text-decoration: none; color: #000; font-weight: bold; cursor: text; }
#angles line, #angles path, #angles circle { stroke: #666; }
#angles text { fill: #333; }
#angles path.drag { fill: #666; cursor: move; }
#angles { text-align: center; margin: 0 auto; width: 350px; }
#angles input, #max { width: 42px; }
</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Matched: {{ Request::session()->get('artist_match') }}</li>
  <li class="breadcrumb-item"><a href="/albumlist/{{ Request::session()->get('artist_id') }}">{{ Request::session()->get('artist_name') }}</a></li>
  <li class="breadcrumb-item"><a href="/tracklist/{{ Request::session()->get('album_id') }}">{{ Request::session()->get('album_name') }}</a></li>
  <li class="breadcrumb-item active">{{ Request::session()->get('track_name') }}</li>
</ol>

<div id="vis" style="display:block;padding-left:100px"></div>

<form id="form">

<div style="text-align: center; margin-left:30px;">
  <div id="custom-area">
    <p><textarea hidden id="text">
		{!! $data !!}
    </textarea>
    <button id="go" type="submit">Go!</button>
  </div>
</div>

<hr>

<div style="float: right; text-align: right">
  <p><label for="max">Number of words:</label> <input type="number" value="250" min="1" id="max">
  <p><label for="per-line"><input type="checkbox" id="per-line"> One word per line</label>
  <!--<p><label for="colours">Colours:</label> <a href="#" id="random-palette">get random palette</a>-->
  <p><label>Download:</label>
    <button id="download-svg">SVG</button><!-- |
    <a id="download-png" href="#">PNG</a>-->
</div>

<div style="float: left">
  <p><label>Spiral:</label>
    <label for="archimedean"><input type="radio" name="spiral" id="archimedean" value="archimedean" checked="checked"> Archimedean</label>
    <label for="rectangular"><input type="radio" name="spiral" id="rectangular" value="rectangular"> Rectangular</label>
  <p><label for="scale">Scale:</label>
    <label for="scale-log"><input type="radio" name="scale" id="scale-log" value="log" checked="checked"> log n</label>
    <label for="scale-sqrt"><input type="radio" name="scale" id="scale-sqrt" value="sqrt"> √n</label>
    <label for="scale-linear"><input type="radio" name="scale" id="scale-linear" value="linear"> n</label>
  <p><label for="font">Font:</label> <input type="text" id="font" value="Impact">
</div>

<div id="angles">
  <p><input type="number" id="angle-count" value="5" min="1"> <label for="angle-count">orientations</label>
    <label for="angle-from">from</label> <input type="number" id="angle-from" value="-60" min="-90" max="90"> °
    <label for="angle-to">to</label> <input type="number" id="angle-to" value="60" min="-90" max="90"> °
</div>

<hr style="clear: both">

<p style="float: right"><a href="about/">How the Word Cloud Generator Works</a>.
<p style="float: left">Copyright &copy; <a href="http://www.jasondavies.com/">Jason Davies</a> | <a href="../privacy/">Privacy Policy</a>. The generated word clouds may be used for any purpose.

</form>

<script src="/js/d3.min.js"></script>
<script src="/js/cloud.min.js"></script>
</body>

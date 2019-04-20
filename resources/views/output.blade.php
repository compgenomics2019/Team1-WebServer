<!doctype html>
<html lang="en">
<head>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://d3js.org/d3.v4.min.js"></script>
</head>
<body>

@extends("main_template")

@section('title', 'WebServer')

@section("navbar")
    <nav class="navbar navbar-expand-lg navbar-custom">
        <!--<img class="img" style="width:2%; display: block; height:2%" src="img/Icon.png">-->
        <a class="navbar-brand" href=""> Team1 Webserver - Results</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="navbarDropdown" role="button" aria-haspopup="true"
                       aria-expanded="false" href={{url('/')}}>
                        Back to Home
                    </a>
                </li>
            </ul>
        </div>
    </nav>
@endsection
@section("main_container")
<div class="container" style="max-width:90%">
	<label id="show-length"><input type="checkbox"> Show branch length</label><br>

	<input type="radio" name="gender" value="0"> Source Site
	<input type="radio" name="gender" value="1"> Source Type
	<input type="radio" name="gender" value="2" checked> State
	<div class="row">
		  <div class="column">
		   
			<div id="main" class="container" style="margin-top:100px">
			</div>
			<script type="text/javascript" src="{{ URL::asset('js/StackedPlot.js') }}"></script>
		  </div>
		  <div class="column">
				<div id="drop"></div>
		  </div>
    </div>
</div>
<style>
		body {
		  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		  margin: 0;
		}

		#show-length {
		  position: absolute;
		}

		.links {
		  fill: none;
		  stroke: #000;
		  stroke-width:5
		}

		.link-extensions {
		  fill: none;
		  stroke: #000;
		  stroke-opacity: .25;
		}

		.labels {
		  font: 10px sans-serif;
		}

		.link--active {
		  stroke: #000 !important;
		  stroke-width: 1.5px;
		}

		.link-extension--active {
		  stroke-opacity: .6;
		}

		.label--active {
		  font-weight: bold;
		}
</style>
@endsection
@section("main_container2")
@endsection
@section("footer")
@endsection
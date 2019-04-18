<!doctype html>
<html lang="en">
<head>
	<script type="text/javascript" src="{{ URL::asset('http://d3js.org/d3.v3.js') }}"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="{{ asset('css/tree.css') }}" rel="stylesheet" type="text/css" >
	<script type="text/javascript" src="{{ URL::asset('js/test.js') }}"></script>
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
     <div class="container">
        <h4>Output</h4>
		<div id="chart"></div>
    </div>
@endsection
@section("main_container2")
	<div class="container">
        <div id="drop"></div>
		<div class="row">
            <div class="col" id="histogram_outbreak">
			<h4>Outbreak</h4>
			</div>
			<div class="col" id="histogram_sporadic">
			<h4>Sporadic</h4>
			</div>
		</div>
    </div>
@endsection
@section("footer")
@endsection
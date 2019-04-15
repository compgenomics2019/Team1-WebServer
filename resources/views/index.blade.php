

@extends("main_template")

@section('title', 'WebServer')

@section("navbar")
<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href=""> Team1 Webserver</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" id="navbarDropdown" role="button" aria-haspopup="true"
                   aria-expanded="false" href={{url('FileManager/ready')}}>
                    File Manager
                </a>
            </li>
        </ul>
    </div>
</nav>
@endsection

@section("main_container")
<div class="container-fluid">
    <div class="banner" style="width:100%; display:block;border: black medium solid;border-radius: 10px;">
        <img class="banner-img" style="width:100%; display: block; height:5%" src="img/banner.jpg">
    </div>
</div>
@endsection

@section("main_container2")
<div class="container" style="text-align: center;">
    <ul id="progress">
        <li class="steps">Gene Assembly</li>
        <li class="steps">Gene Prediction</li>
        <li class="steps">Gene Annotation</li>
        <li class="steps">Comparative Genomics</li>
    </ul>
    <br>
    <br>
    <br>
    <div class="container" style="text-align: justify;">
        <div class="row">
            <div class="col">
                <div class="overlay" style="background-color: #edebeb">
                    <img class="img" style="width:100%; display: block; height:100%" src="img/compare.png">
                </div>
                <h5 style="font-family:verdana;text-align: center;"><a href={{url('analysis')}}>Start Analysis</a></h5>
            </div>
            <div class="col">
                <div class="overlay" style="background-color: #edebeb">
                    <img class="img" style="width:100%; display: block; height:100%" src="img/compare.png">
                </div>
                <h5 style="font-family:verdana;text-align: center;"><a href="https://compgenomics2019.biosci.gatech.edu/Team_I_Webserver_Group">Tutorial</a></h5>
            </div>
            <div class="col">
                <div class="overlay" style="background-color: #edebeb">
                    <img class="img" style="width:100%; display: block; height:100%" src="img/compare.png">
                </div>
                <h5 style="font-family:verdana;text-align: center;"><a href={{url('about')}}>About Us</a></h5>
            </div>
        </div>
    </div>
</div>
@endsection
@section("footer")
<div class="container-fluid" style="background-color: black; position: fixed; left: 0; bottom: 0;">
    <footer style="text-align: center;">
        <br>
        <p style="color: white;"> &copy 2019 Team 1 Predictive Webserver Group</p>
        <br>
    </footer>
</div>
@endsection
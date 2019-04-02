

@extends("main_template")

@section('title', 'WebServer')

@section("navbar")
    <nav class="navbar navbar-expand-lg navbar-custom">
        <!--<img class="img" style="width:2%; display: block; height:2%" src="img/Icon.png">-->
        <a class="navbar-brand" href=""> Team1 Webserver - Functional Annotation</a>
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
        <form class="needs-validation" novalidate>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip02">Choose File</label>
                    <select id="inputState" class="form-control">
                        @foreach ($files as $f)
                            <option>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip01">Output file name</label>
                    <input type="text" class="form-control" id="validationTooltip01" placeholder="output.gff" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="inputState">Tools</label>
                    <div style="margin-top:5px">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">EggNOG</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">TMHMM</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label for="validationTooltip01">Email</label>
                    <input type="text" class="form-control" id="validationTooltip01" placeholder="example@gatech.edu">
                </div>
                <div class="col-md-6 mb-3">
                    <label>After Annotation</label>
                    <div style="margin-top:5px">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Delete input</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option4">
                            <label class="form-check-label" for="inlineCheckbox3">Continue comparative</label>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Start</button>
        </form>
    </div>
@endsection
@section("main_container2")
    <div class="container">
        <text>Output</text>
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
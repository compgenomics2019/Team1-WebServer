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
                        <img class="img" style="width:100%; display: block; height:100%" src="img/gears.png">
                    </div>
                    <h5 style="font-family:verdana;text-align: center;">
                        <a href="#myModal" role="button" class="btn" data-toggle="modal">Run</a>
                    </h5>
                </div>
                <div class="col">
                    <div class="overlay" style="background-color: #edebeb">
                        <img class="img" style="width:100%; display: block; height:100%" src="img/manual.png">
                    </div>
                    <h5 style="font-family:verdana;text-align: center;"><a
                                href="https://compgenomics2019.biosci.gatech.edu/Team_I_Webserver_Group">Tutorial</a>
                    </h5>
                </div>
                <div class="col">
                    <div class="overlay" style="background-color: #edebeb">
                        <img class="img" style="width:100%; display: block; height:100%" src="img/team.png">
                    </div>
                    <h5 style="font-family:verdana;text-align: center;"><a href={{url('about')}}>About Us</a></h5>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Head">Analysis Pipeline</h5>
                </div>

                {{--<form class="needs-validation" method="get" action="analysis/start" novalidate>--}}
                {{--<form class="needs-validation" novalidate>--}}
                    {{--IO options--}}
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">InputFile#1</label>
                                <select id="inputFile" name="inputFile1" class="form-control">
                                    @foreach ($files as $f)
                                        <option>{{ $f }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">InputFile#2</label>
                                <select id="inputFile" name="inputFile2" class="form-control">
                                    @foreach ($files as $f)
                                        <option>{{ $f }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip01">JobName</label>
                                <input type="text" class="form-control" name="jobName" id="jobname" placeholder="job1"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip01">Email</label>
                                <input type="text" class="form-control" name="email" id="email"
                                       placeholder="example@gatech.edu" required>
                            </div>
                        </div>
                        <div class="form-row">
                            {{--assembly options--}}
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doAssemble" id="inlineCheckbox1" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Assemble</label>
                            </div>
                            {{--gene prediction options--}}
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doPrediction" id="inlineCheckbox1" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Gene Prediction</label>
                            </div>
                        </div>
                        {{--functional annotation options--}}
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doAnnotation" id="inlineCheckbox1" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Functional Annotation</label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="annotationRadio" id="inlineCheckbox" value="vfdb" checked="checked">
                                    <label class="form-check-label" for="inlineCheckbox1">vfDB</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="annotationRadio" id="inlineCheckbox" value="card">
                                    <label class="form-check-label" for="inlineCheckbox2">CARD</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            {{--comparative genomics options--}}
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doComparative" id="inlineCheckbox1" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Comparative Analysis</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                        {{--<button class="btn btn-success" id="play" type="submit">Run</button>--}}
                        <button class="btn btn-success" id="run2_button"
                                onClick="clickrun()">Run2
                        </button>
                    </div>
                {{--</form>--}}
            </div>
        </div>
    </div>

    <script>
        function clickrun() {
            document.getElementById("Head").innerHTML = "Analysis Pipeline is running" + '<img src="img/ajax-loader.gif" alt="Wait" />';
            console.log("function is running");
            var url = 'start_ajax';
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    inputFile1: $('#inputFile1').val(),
                    inputFile2: $('#inputFile2').val(),
                    jobName: $('#jobName').val(),
                    annotationRadio: $("annotationRadio").val()
                },
                success: function (result) {
                    console.log("ajax succcess");
                    console.log(result);
                },
                error: function (result) {
                    console.log("ajax error");
                    console.log(result.responseJSON);
                    document.getElementById("Head").innerHTML = "Analysis Pipeline";
                    alert(result.responseJSON["error"]);
                }
            });

        }

    </script>
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
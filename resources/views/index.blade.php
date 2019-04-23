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
                                <select id="inputFile1" name="inputFile1" class="form-control">
                                    @foreach ($files as $f)
                                        <option>{{ $f }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">InputFile#2</label>
                                <select id="inputFile2" name="inputFile2" class="form-control">
                                    @foreach ($files as $f)
                                        <option>{{ $f }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip01">JobName</label>
                                <input type="text" class="form-control" name="jobName" id="jobName" placeholder="job1"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip01">Email</label>
                                <input type="text" class="form-control" name="email" id="email"
                                       placeholder="example@gatech.edu">
                            </div>
                        </div>
                        <div class="form-row">
                            {{--assembly options--}}
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doAssemble" id="doAssemble" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Assemble</label>
                            </div>
                            {{--gene prediction options--}}
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doPrediction" id="doPrediction" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Gene Prediction</label>
                            </div>
                        </div>
                        {{--functional annotation options--}}
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doAnnotation" id="doAnnotation" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Functional Annotation</label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="annotationRadio" id="annotationRadio" value="vfdb" checked="checked">
                                    <label class="form-check-label" for="inlineCheckbox1">vfDB</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="annotationRadio" id="annotationRadio" value="card">
                                    <label class="form-check-label" for="inlineCheckbox2">CARD</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            {{--comparative genomics options--}}
                            <div class="col-md-6 mb-3">
                                <input class="" type="checkbox" name="doComparative" id="doComparative" value="1"
                                       checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Comparative Analysis</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                        {{--<button class="btn btn-success" id="play" type="submit">Run</button>--}}
                        <button class="btn btn-success" id="run2_button"
                                onClick="clickrun()">Run
                        </button>
                    </div>
                {{--</form>--}}
            </div>
        </div>
    </div>
<div id="Success" class="modal fade">
     <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Head">Success!</h5>
                </div>
				<div class="modal-body" style="text-align:center">
				    <h7> Follow this link for results: </h7>
                    <a style="text-align:center" href={{url('output')}}>http://predict2019t1.biosci.gatech.edu/output</a>
                </div>
        </div>
     </div>
</div>

<div id="Error" class="modal fade">
     <div class="modal-dialog">
        <div class="modal-content">
				<div class="modal-body">
				    <h7>Error! Check Inputs</h7>
                </div>
		<div class="modal-footer">
              <button class="btn btn-danger" data-dismiss="modal">OK</button>
       </div>
        </div>
     </div>
</div>

<script>
function clickrun() {
            document.getElementById("Head").innerHTML = "Analysis Pipeline" + '<img src="img/ajax-loader.gif" alt="Wait" />';
            console.log("function is running");
            var url = 'start_ajax';
            var f1 = $('#inputFile1').val();
            var f2 = $('#inputFile2').val();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    inputFile1: f1,
                    inputFile2: f2,
                    jobName: $('#jobName').val(),
                    annotationRadio: $("#annotationRadio").val(),
                    email: $("#email").val(),
                    doAssemble: $("#doAssemble").val(),
                    doPrediction: $("#doPrediction").val(),
                    doAnnotation: $("#doAnnotation").val(),
                    doComparative: $("#doComparative").val()

                },
                success: function (result) {
					document.getElementById("Head").innerHTML = "Analysis Pipeline";
                    console.log(result);
                    $("#myModal").modal('hide');
                    $("#Success").modal('show');
                    win=window.open("http://127.0.0.1:8000/output");
					setTimeout(function() {
win.ready("(((CGT1803:0.0,CGT1831:0.0):0.00014,(CGT1036:0.0,Input:0.0):0.00015)0.000:0.00015,((((((CGT1292:0.00054,CGT1595:0.00014)0.767:0.00053,CGT1145:0.00015)0.000:0.00014,CGT1751:0.00015)0.595:0.00015,((((CGT1288:0.00014,((CGT1200:0.00015,CGT1913:0.00994)0.997:0.00863,CGT1671:0.00721)1.000:0.01494)1.000:0.98756,(((CGT1204:0.00161,CGT1357:0.00378)0.997:0.00647,((CGT1686:0.00689,CGT1203:0.00310)0.967:0.00351,CGT1240:0.00592)0.999:0.00701)0.993:0.00535,CGT1743:0.00014)1.000:0.41707)0.827:0.05405,((((CGT1552:0.00105,CGT1042:0.00106)0.603:0.00014,CGT1891:0.00176)0.979:0.00351,CGT1729:0.00104)0.987:0.00582,CGT1814:0.00014)1.000:0.22699)1.000:0.13625,((CGT1688:0.02774,CGT1365:0.00193)1.000:0.02389,CGT1953:0.00014)1.000:0.10406)1.000:0.11930)0.000:0.00011,(CGT1032:0.0,CGT1058:0.0,CGT1759:0.0):0.00052)0.706:0.00053,(CGT1785:0.00273,CGT1548:0.00052)0.732:0.00053)0.989:0.00375,(((CGT1020:0.00053,CGT1720:0.00014)0.933:0.00206,CGT1704:0.00014)0.795:0.00014,(((CGT1358:0.00014,(((CGT1077:0.0,CGT1166:0.0,CGT1217:0.0,CGT1309:0.0,CGT1419:0.0):0.00014,(CGT1294:0.0,CGT1350:0.0,CGT1572:0.0,CGT1632:0.0):0.00014)0.000:0.00014,CGT1239:0.00014)0.000:0.00014)0.922:0.00100,(CGT1476:0.00014,(CGT1752:0.00014,CGT1491:0.00014)0.000:0.00014)0.903:0.00015)0.804:0.00053,(CGT1033:0.0,CGT1602:0.0):0.00016)0.810:0.00055)0.000:0.00014);");
					}, 2000);
                },
                error: function (result) {
                    console.log("ajax error");
                    console.log("resultjson: ", result.responseJSON);
                    console.log("resulttext: ", result.responseText);
                    console.log("result", result);
                    document.getElementById("Head").innerHTML = "Analysis Pipeline";
                    $("#Error").modal('show');
                    win=window.open("http://127.0.0.1:8000/output");
					setTimeout(function() {
win.ready("(((CGT1803:0.0,CGT1831:0.0):0.00014,(CGT1036:0.0,Input:0.0):0.00015)0.000:0.00015,((((((CGT1292:0.00054,CGT1595:0.00014)0.767:0.00053,CGT1145:0.00015)0.000:0.00014,CGT1751:0.00015)0.595:0.00015,((((CGT1288:0.00014,((CGT1200:0.00015,CGT1913:0.00994)0.997:0.00863,CGT1671:0.00721)1.000:0.01494)1.000:0.98756,(((CGT1204:0.00161,CGT1357:0.00378)0.997:0.00647,((CGT1686:0.00689,CGT1203:0.00310)0.967:0.00351,CGT1240:0.00592)0.999:0.00701)0.993:0.00535,CGT1743:0.00014)1.000:0.41707)0.827:0.05405,((((CGT1552:0.00105,CGT1042:0.00106)0.603:0.00014,CGT1891:0.00176)0.979:0.00351,CGT1729:0.00104)0.987:0.00582,CGT1814:0.00014)1.000:0.22699)1.000:0.13625,((CGT1688:0.02774,CGT1365:0.00193)1.000:0.02389,CGT1953:0.00014)1.000:0.10406)1.000:0.11930)0.000:0.00011,(CGT1032:0.0,CGT1058:0.0,CGT1759:0.0):0.00052)0.706:0.00053,(CGT1785:0.00273,CGT1548:0.00052)0.732:0.00053)0.989:0.00375,(((CGT1020:0.00053,CGT1720:0.00014)0.933:0.00206,CGT1704:0.00014)0.795:0.00014,(((CGT1358:0.00014,(((CGT1077:0.0,CGT1166:0.0,CGT1217:0.0,CGT1309:0.0,CGT1419:0.0):0.00014,(CGT1294:0.0,CGT1350:0.0,CGT1572:0.0,CGT1632:0.0):0.00014)0.000:0.00014,CGT1239:0.00014)0.000:0.00014)0.922:0.00100,(CGT1476:0.00014,(CGT1752:0.00014,CGT1491:0.00014)0.000:0.00014)0.903:0.00015)0.804:0.00053,(CGT1033:0.0,CGT1602:0.0):0.00016)0.810:0.00055)0.000:0.00014);");
					}, 2000);
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
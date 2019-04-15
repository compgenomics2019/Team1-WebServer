

@extends("main_template")

@section('title', 'WebServer - Analysis')

@section("navbar")
    <nav class="navbar navbar-expand-lg navbar-custom">
        <!--<img class="img" style="width:2%; display: block; height:2%" src="img/Icon.png">-->
        <a class="navbar-brand" href=""> Team1 Webserver - Genome Analysis</a>
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
        <form class="needs-validation" method="get" action="start" novalidate>
            {{--IO options--}}
            <div class="form-row">
                <div class="col-md-1 mb-3">
                    <p>I/O options:</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip02">Input File</label>
                    <select id="inputState" class="form-control">
                        @foreach ($files as $f)
                        <option>{{ $f }}</option>
                        @endforeach
                            {{--<option>asfasf</option>--}}
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip01">Output file name</label>
                    <input type="text" class="form-control" id="validationTooltip01" placeholder="output.gff" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip01">Email notification</label>
                    <input type="text" class="form-control" id="validationTooltip01" placeholder="example@gatech.edu" required>
                </div>
            </div>
            {{--assembly options--}}
            <div class="form-row">
                <div class="col-md-1 mb-3">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="run_genome_assembly" checked="checked">
                    <label class="form-check-label" for="inlineCheckbox1">Assemble</label>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="validationTooltip05">Trim</label>
                    <select id="inputState" class="form-control">
                        <option selected>Yes</option>
                        <option>No</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="kmer_size">kmer size</label>
                    <input type="text" class="form-control" id="kmer_size" placeholder="give a kmer size">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Choose a Tool</label>
                    <div style="margin-top:5px">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Spades</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">MaSuRCa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                            <label class="form-check-label" for="inlineCheckbox3">Skesa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option4">
                            <label class="form-check-label" for="inlineCheckbox3">Abyss</label>
                        </div>
                    </div>
                </div>
            </div>
            {{--gene prediction options--}}
            <div class="form-row">
                <div class="col-md-1 mb-3">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="run_gene_prediction">
                    <label class="form-check-label" for="inlineCheckbox1">Gene Prediction</label>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Choose a Tool</label>
                    <div style="margin-top:5px">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Spades</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">MaSuRCa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                            <label class="form-check-label" for="inlineCheckbox3">Skesa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option4">
                            <label class="form-check-label" for="inlineCheckbox3">Abyss</label>
                        </div>
                    </div>
                </div>
            </div>
            {{--functional annotation options--}}
            <div class="form-row">
                <div class="col-md-1 mb-3">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="run_genome_assembly">
                    <label class="form-check-label" for="inlineCheckbox1">Functional Annotation</label>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Choose a Tool</label>
                    <div style="margin-top:5px">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Spades</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">MaSuRCa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                            <label class="form-check-label" for="inlineCheckbox3">Skesa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option4">
                            <label class="form-check-label" for="inlineCheckbox3">Abyss</label>
                        </div>
                    </div>
                </div>
            </div>
            {{--comparative genomics options--}}
            <div class="form-row">
                <div class="col-md-1 mb-3">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="run_genome_assembly">
                    <label class="form-check-label" for="inlineCheckbox1">Comparative Analysis</label>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Choose a Tool</label>
                    <div style="margin-top:5px">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Spades</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">MaSuRCa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                            <label class="form-check-label" for="inlineCheckbox3">Skesa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option4">
                            <label class="form-check-label" for="inlineCheckbox3">Abyss</label>
                        </div>
                    </div>
                </div>
            </div>

            {{--submit--}}
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
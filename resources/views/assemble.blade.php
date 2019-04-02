

@extends("main_template")

@section('title', 'WebServer')

@section("navbar")
    <nav class="navbar navbar-expand-lg navbar-custom">
        <!--<img class="img" style="width:2%; display: block; height:2%" src="img/Icon.png">-->
        <a class="navbar-brand" href=""> Team1 Webserver - Genome assembly</a>
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
                    <label for="validationTooltip01">SRA Run Accession #</label>
                    <input type="text" class="form-control" id="validationTooltip01" placeholder="SRR" required>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip02">Browse File</label>
                    <input style="margin-top:5px" type="file" class="form-control-file" id="exampleFormControlFile1">  {{--todo: brwose file--}}
                </div>
                <div class="col-md-3 mb-3">
                    <label>Output file name</label>
                    <input type="text" class="form-control" id="validationTooltip04" placeholder="output.fasta" required>
                </div>
            </div>
            <div class="form-row">
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
                    <label>Tools</label>
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
            <div class="form-row">
                <div class="col-md-2 mb-3">
                <label>Email</label>
                    <input type="text" class="form-control" id="validationTooltip05" placeholder="example@gatech.edu" required>
                </div>
                <div class="col-md-8 mb-3">
                    <label>After assemble</label>
                    <div style="margin-top:5px">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Delete input</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">Continue prediction</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                            <label class="form-check-label" for="inlineCheckbox3">Continue annotation</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option4">
                            <label class="form-check-label" for="inlineCheckbox3">Continue comparative</label>
                        </div>
                    </div>
                </div>

            </div>
            <button class="btn btn-primary" type="submit">Assemble</button>
        </form>

    </div>
@endsection

@section("main_container2")
    <div class="container">
        <p>Output</p>
        <img src="img/sample_quast_report.png">
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
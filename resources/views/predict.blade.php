

@extends("main_template")

@section('title', 'WebServer')

@section("navbar")
    <nav class="navbar navbar-expand-lg navbar-custom">
        <!--<img class="img" style="width:2%; display: block; height:2%" src="img/Icon.png">-->
        <a class="navbar-brand" href=""> Team1 Webserver - Gene prediction</a>
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
        <text>Input</text>
        <div class="container">
            <p>Input files and parameters is defined here</p>
            {{--<br>--}}
            <form>
                Specify input file:<br>
                <input type="radio" name="infile" value="file">File
                <label style="font-style: italic">Foo.fasta</label>
                <button type="button">
                    Browse file
                </button>
                <br>
                Select Tool to use:
                <select>
                    <option value ="SPAdes">Foo</option>
                    <option value ="SKESA">Bar</option>
                </select>
                <br>
                {{--<input type="checkbox">Trim--}}
                {{--<br>--}}
                Leave your email:
                <input type="text" name="sra session">
                <br>
                <button type="submit"
                        formaction="http://www.google.com"
                        formmethod="post">Start Assemble</button>
            </form>
        </div>
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
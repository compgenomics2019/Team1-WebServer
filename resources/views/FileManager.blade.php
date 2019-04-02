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
        <div>
            @foreach ($assemble_files as $f)
                <li>{!! $f !!}</li>
            @endforeach
            @foreach ($prediction_files as $f)
                <li>{!! $f !!}</li>
            @endforeach
            @foreach ($annotation_files as $f)
                <li>{!! $f !!}</li>
            @endforeach
            @foreach ($comparative_files as $f)
                <li>{!! $f !!}</li>
            @endforeach
        </div>
    </div>
@endsection

@section("main_container2")
    <div class="container">
        <form class="form-horizontal" method="POST" action="file/file_upload" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="file">Choose file</label>
                    <input id="file" type="file" class="form-control" name="filename" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationTooltip05">Category</label>
                    <select id="fileCategory" name="fileCategory[]" class="form-control">
                        <option value="assemble" selected>Assemble</option>
                        <option value="prediction">Prediction</option>
                        <option value="annotation">Annotation</option>
                        <option value="comparative">Comparative</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label>New file name</label>
                    <input type="text" class="form-control" id="newFileName" name="newFileName" placeholder="target.test" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Click to upload file</label>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <form class="form-horizontal" method="POST" action="file/downloadOrDelete" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="file">Type in file name</label>
                    <input type="text" class="form-control" id="newFileName" name="fileName" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationTooltip05">Category</label>
                    <input type="text" class="form-control" id="newFileName" name="fileCategory" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Download file</label>
                    <button type="submit" class="btn btn-primary" name="btn" value="download">Download</button>
                </div>
                <div class="col-md-1 mb-3">
                    <label>Delete file</label>
                    <button type="submit" class="btn btn-primary" name="btn" value="delete">Delete</button>
                </div>
            </div>
        </form>
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




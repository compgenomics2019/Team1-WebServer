<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="content">
    <div class="title m-b-md">
        Upload
    </div>
</div>
<div class="container">
    <div class="panel-heading">Upload file here</div>
    <form class="form-horizontal" method="POST" action="upload/file_upload" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label for="file">Choose file</label>
        <input id="file" type="file" class="form-control" name="filename" required>

        <label for="validationTooltip05">Category</label>
        <select id="fileCategory" name="fileCategory[]" class="form-control">
            <option value="assemble" selected>Assemble</option>
            <option value="prediction">Prediction</option>
            <option value="annotation">Annotation</option>
            <option value="comparative">Comparative</option>
        </select>

        <label>New file name</label>
        <input type="text" class="form-control" id="newFileName" name="newFileName" placeholder="target.test" required>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="img/Icon.png"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Team 1 Predictive Web Server</title>

    <link rel="stylesheet" href="css/Home.css">
    <style type="text/css">
        dummydeclaration {
            padding-left: 4em;
        }

        /* For Firefox */
        tab1 {
            padding-left: 4em;
        }

        tab2 {
            padding-left: 8em;
        }

        tab3 {
            padding-left: 12em;
        }

        /* change the background color */
        .navbar-custom {
            background-color: #000000;
        }

        /* change the brand and text color */
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            /*color: rgba(255,255,255,.8);*/
            color: #ffffff;
        }

        /* change the link color */
        .navbar-custom .navbar-nav .nav-link {
            color: rgba(255, 255, 255, .5);
        }

        /* change the color of active or hovered links */
        .navbar-custom .nav-item.active .nav-link,
        .navbar-custom .nav-item:hover .nav-link {
            color: #ffffff;
        }

        body {
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
    <style>
        .container-fluid {
            width: 100%;
            position: relative;
            text-align: center;
            color: white;
        }

        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .overlay {
            border: #cdcdcd medium solid;
            background: rgba(255, 255, 255, .95);
            padding: 20px;
            height: 100px;
            width: 100px;
            -webkit-border-radius: 10px;
            display: inline-block;
        }

        .col {
            text-align: center;
        }

        .bar {
            position: relative;
            width: 80px;
            height: 6px;
            margin: 0 -5px 17px -5px;
            border-left: none;
            border-right: none;
            border-radius: 0;
            top: 16px;
            vertical-align: top;
            border: 1px solid #d5d5da;
        }

        * {
            box-sizing: border-box;
        }

        #progress {
            padding: 0;
            list-style-type: none;
            font-family: arial;
            font-size: 12px;
            clear: both;
            line-height: 1em;
            margin: 0 -1px;
            text-align: center;
        }

        #progress li {
            float: left;
            padding: 10px 30px 10px 40px;
            background: #333;
            color: #fff;
            position: relative;
            border-top: 1px solid #666;
            border-bottom: 1px solid #666;
            width: 24%;
            height: 100%;
            margin: 0 1px;
        }

        #progress li:before {
            content: '';
            border-left: 16px solid #fff;
            border-top: 16px solid transparent;
            border-bottom: 16px solid transparent;
            position: absolute;
            top: 0;
            left: 0;

        }

        #progress li:after {
            content: '';
            border-left: 16px solid #333;
            border-top: 16px solid transparent;
            border-bottom: 16px solid transparent;
            position: absolute;
            top: 0;
            left: 100%;
            z-index: 20;
        }

        #progress li:hover {
            background: #555;
        }

    </style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <!--<img class="img" style="width:2%; display: block; height:2%" src="img/Icon.png">-->
    <a class="navbar-brand" href=""> Team1 Webserver</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" id="navbarDropdown" role="button" aria-haspopup="true"
                   aria-expanded="false" href={{url('upload')}}>
                    Upload Files
                </a>
            </li>

            <!-- drop down for assembly -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Pipeline
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">Assemble</a>
                    <a class="dropdown-item" href="">Predict Genes</a>
                    <a class="dropdown-item" href="">Annotate Genes</a>
                    <a class="dropdown-item" href="">Comparative Genomes</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="" role="button" aria-haspopup="true" aria-expanded="false">
                    Team
                </a>
            </li>
        </ul>
    </div>
</nav>
<br>
<div class="container-fluid">
    <div class="banner" style="width:100%; display:block;border: black medium solid;border-radius: 10px;">
        <img class="banner-img" style="width:100%; display: block; height:5%" src="img/banner.jpg">
    </div>
</div>
</br></br>
<div class="container" style="text-align: center;">
    <ul id="progress">
        <li class="steps">Gene Assembly</li>
        <li class="steps">Gene Prediction</li>
        <li class="steps">Gene Annotation</li>
        <li class="steps">Comparative Genomics</li>
    </ul>
    <h1></h1>
    <div class="container" style="text-align: justify;">
        </br></br>
        <div class="row">
            <div class="col">
                <div class="overlay" style="background-color: #edebeb">
                    <img class="img" style="width:100%; display: block; height:100%" src="img/assembly.png">
                </div>
                <h5 style="font-family:verdana;text-align: center;"><a href={{url('assemble')}}>Gene Assembly</a></h5>
            </div>
            <div class="col">
                <div class="overlay" style="background-color: #edebeb">
                    <img class="img" style="width:100%; display: block; height:100%" src="img/prediction.png">
                </div>
                <h5 style="font-family:verdana;text-align: center;"><a href={{url('predict')}}>Gene Prediction</a></h5>
            </div>
            <div class="col">
                <div class="overlay" style="background-color: #edebeb">
                    <img class="img" style="width:100%; display: block; height:100%" src="img/annotation.png">
                </div>
                <h5 style="font-family:verdana;text-align: center;"><a href={{url('annotation')}}>Gene Annotation</a></h5>
            </div>
            <div class="col">
                <div class="overlay" style="background-color: #edebeb">
                    <img class="img" style="width:100%; display: block; height:100%" src="img/compare.png">
                </div>
                <h5 style="font-family:verdana;text-align: center;"><a href={{url('compare')}}>Comparative Genomics</a></h5>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container-fluid" style="background-color: black; position: fixed; left: 0; bottom: 0;">
    <footer style="text-align: center;">
        <br>
        <p style="color: white;"> &copy 2019 Team 1 Predictive Webserver Group</p>
        <br>
    </footer>
</div>
</body>
</html>
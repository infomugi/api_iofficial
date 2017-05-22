<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $appName; ?> <?php echo $pageTitle; ?> - <?php echo $credit; ?></title>

    <!-- CSS -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <!-- Header -->

    <header id="hero" class="hero overlay">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    <a href="#" class="brand">
                        <img src="assets/images/logo.png" alt="IOfficial">
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="http://wefay.com" class="btn btn-success nav-btn">Contact US</a>
                       </li>
                   </ul>
               </div>
           </div>
       </nav>
       <div class="masthead text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1>Rest API <?php echo $appName; ?></h1>
                    <p class="lead text-muted"><?php $appName; ?> Mobile Apps Documentation</p>
                    <a href="<?php echo $documentation; ?>" class="btn btn-hero">Read Documentation</a>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Features -->

<section id="features" class="features bgc-light-gray">
    <div class="container ">
        <div class="row features-section">
            <div class="text-center col-sm-4">
                <div class="media-body">
                    <span class="icon"><img src="assets/images/icon/icon1.png" alt=""></span>
                    <h3>Help & Documentation</h3>
                    <p class="text-muted">Unlike other Frameworks which try to cover everything, It has been built specifically for mobile</p>
                </div>
            </div>
            <div class="text-center col-sm-4">
                <div class="media-body">
                    <span class="icon"><img src="assets/images/icon/icon2.png" alt=""></span>
                    <h3>Developer Resources</h3>
                    <p class="text-muted">An incredibly codex has been created for you to use as reference when developing extensions</p>
                </div>
            </div>
            <div class="text-center col-sm-4">
                <div class="media-body">
                    <span class="icon"><img src="assets/images/icon/icon3.png" alt=""></span>
                    <h3>Community Support</h3>
                    <p>The source code is available on GitHub, you can grab it and twist it to your heart’s content</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12 text-center">
            <div class="copyright">
                <p>© <?php echo date('Y'); ?> <?php echo $appName; ?> by <?php echo $credit; ?></p>
            </div>
        </div>
    </div>
</div>
</footer>

<script src="assets/js/jquery-1.12.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

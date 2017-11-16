  <html>
  <head>
    <title>Schedulr</title>
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/paper-kit.css">
    

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="<?php echo base_url()?>/assets/js/validation.js" /></script>
    <script src="<?php echo base_url()?>/assets/js/angular-notify.js"></script>
    <script src="<?php echo base_url()?>/assets/js/main.js" /></script>
    <script src="<?php echo base_url()?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>/assets/js/paper-kit.js"></script>
  </head>

  <body>
    <div class="home">
      <nav class="navbar navbar-expand-md bg-transparent">
        <div class="container">
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar-success" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar"></span>
            <span class="navbar-toggler-bar"></span>
            <span class="navbar-toggler-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>index">Schedulr</a>
          <div class="collapse navbar-collapse" id="navbar-success">
            <ul class="nav navbar-nav navbar-left">
              <li class="nav-item">
                <a class="nav-link" href="About">About</a>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>login">Sign In</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-round btn-info" href="<?php echo base_url(); ?>register">Sign Up</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

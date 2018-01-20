<html>
<head>
  <title>Schedulr</title>
  <script src="<?php echo base_url()?>/assets/js/angular.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-resource.min.js"></script>
    <script src="<?php echo base_url()?>/assets/js/jquery.js"></script>


  
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/angular-datepicker.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/wickedpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/angular-notify.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/font-awesome.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery/jquery-ui.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery/jquery-ui.theme.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery/jquery-ui.structure.css">
  <link rel='stylesheet' href='<?php echo base_url()?>/assets/css/fullcalendar.css' />
  <link rel='stylesheet' href='<?php echo base_url()?>/assets/css/qtip.css' />

  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/custom.css">
  <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/paper-kit.css">
  


  <script src="<?php echo base_url()?>/assets/js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url()?>/assets/js/timepickerdirective.js"></script>
  <script src="<?php echo base_url()?>/assets/js/wickedpicker.min.js"></script>
  <script src="<?php echo base_url()?>/assets/js/angular-notify.js"></script>
  <script src="<?php echo base_url()?>/assets/js/validation.js"></script>
  <script src="<?php echo base_url()?>/assets/js/display.js"></script>
  <script src="<?php echo base_url()?>/assets/js/task.js"></script>
  <script src="<?php echo base_url()?>/assets/js/profile.js"></script>
  <script src="<?php echo base_url()?>/assets/js/angular-datepicker.js"></script>
  <script src="<?php echo base_url()?>/assets/js/popper.js"></script>
  <script src="<?php echo base_url()?>/assets/js/moment.min.js"></script>
  <script src="<?php echo base_url()?>/assets/js/fullcalendar.js"></script>
  <script src="<?php echo base_url()?>/assets/js/main.js"></script>
  <script src="<?php echo base_url()?>/assets/js/qtip.js"></script>
  <script src="<?php echo base_url()?>/assets/js/calendar.js"></script>
  <script src="<?php echo base_url()?>/assets/js/bootstrap.min.js"></script>




</head>

<body>

<nav class="navbar navbar-expand-md bg-transparent">
  <div class="container">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar-success" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar"></span>
      <span class="navbar-toggler-bar"></span>
      <span class="navbar-toggler-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url(); ?>users/index">Schedulr</a>

    <div class="collapse navbar-collapse" id="navbar-success">
      <ul class="nav navbar-nav navbar-left">
        <li>
          <a class="btn btn-success btn-round" href="<?php echo base_url(); ?>tasks/create">New Task</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>users/index">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>users/profile">Profile</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-info btn-round" href="<?php echo base_url(); ?>Users/logout">Sign Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>



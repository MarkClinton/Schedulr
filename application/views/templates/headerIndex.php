  <html>

  <head>
    <title>Schedulr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="<?php echo base_url() ?>/assets/js/jquery.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/bootstrap-switch.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/paper-kit.js"></script>


    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>/assets/images/favicon-96x96.png">

    <!--
      Loading JQuery twice is NOT the way to do it. This needs to be reviewed. 
      Conflicting JS Files.
    -->
    <script src="<?php echo base_url() ?>/assets/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-resource.min.js"></script>


    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/angular-datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/wickedpicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/angular-notify.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/jquery/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/jquery/jquery-ui.theme.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/jquery/jquery-ui.structure.css">
    <link rel='stylesheet' href='<?php echo base_url() ?>/assets/css/fullcalendar.css' />
    <link rel='stylesheet' href='<?php echo base_url() ?>/assets/css/qtip.css' />
    <link rel='stylesheet' href='<?php echo base_url() ?>/assets/css/angular-confirm.min.css' />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/mobile.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/paper-kit.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">



    <script src="<?php echo base_url() ?>/assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/timepickerdirective.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/wickedpicker.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/angular-notify.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/angular-confirm.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/angular-confirm.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/validation.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/display.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/task.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/profile.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/angular-datepicker.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/popper.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/moment.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/fullcalendar.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/main.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/qtip.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/calendar.js"></script>


  </head>

  <body>
    <div class="home" id="home">
      <nav class="navbar navbar-expand-md">
        <div class="container">
          <button class="navbar-toggler navbar-toggler-right" id="menu-collapse" type="button" data-toggle="collapse" data-target="#navbar-success" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar"></span>
            <span class="navbar-toggler-bar"></span>
            <span class="navbar-toggler-bar"></span>
          </button>
          <div class="circle-logo"></div>
          <a class="navbar-brand" href="<?php echo base_url(); ?>index">Schedulr.</a>
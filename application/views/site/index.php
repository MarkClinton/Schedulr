<div class="navbar-collapse" id="navbar-success">
  <ul class="nav navbar-nav ml-auto">
    <li class="nav-item">
      <a class="btn-light-blue btn btn-link btn-round btn-sm" onclick="openLogin()">Log In</a>
    </li>
    <li class="nav-item">
      <a class="btn-main-blue btn btn-sm btn-neutral" onclick="openReg()">Sign Up</a>
    </li>
  </ul>
</div>
</div>
</nav>


<div class="contain_main" ng-app="user">
  <div id="overlay-back"></div>
  <div class="contain_index">



    <div class="mobile_welcome">
      <h1 style="color:#FAFAFA;">Take Control Of Your Day</h1>
      <br>
      <h6 style="color:#FAFAFA;">Schedulr is an organizational tool designed to show you a snapshot of your weekly, monthly and daily tasks</h6>
    </div>

    <div class="mobile_welcome_sml">
      <h6 style="color:#FAFAFA; font-size: 26px;">Take Control Of Your Day</h6>
    </div>

    <div class="image_contain_main">
      <img class="home-main" src="assets/images/home_main_2.png" alt="main_icon">
    </div>

  </div>


  <!-- 
  Login popup container
 -->
  <div id="login" class="login sideNav-index">

    <div class="nav-header">
      <h6 class="top-margin" style="color: #FAFAFA; float:left; margin-left: 10px">Login</h6>
      <button type="button" onclick="closeLogin()" class="btn btn-neutral btn-link btn-sm top-margin pull-right">
        <i class="fa fa-times"></i>
      </button>
    </div>

    <div class="contain">
      <form class="form-horizontal" ng-controller="indexCtrl" ng-submit="login()">
        <fieldset>
          <div class="form-group" ng-class="{ 'has-error': userForm.$invalid }">
            <div class="col-lg-12">
              <input class="form-control" ng-model="user.email" placeholder="Email" type="email" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <input class="form-control" ng-model="user.password" placeholder="Password" type="password" required>
            </div>

          </div>
          <div class="left margin-left">
            <button type="submit" class="btn btn-success">Sign In</button>
            <!--<button type="button" onclick="closeLogin()" class="btn btn-danger btn-round">Close</button>-->
          </div>
          <div class="left margin-left">
            <a href="forgot_password">
              <h6 style="color: #51bcda">
                <h6 style="color: #51bcda">Forgot Password?</h6>
              </h6>
            </a>
          </div>
        </fieldset>
      </form>
    </div>
  </div>

  <!-- 
    Register popup container
    -->
  <div id="reg" class="sideNav-index reg">
    <div class="nav-header">
      <h6 class="top-margin" style="color: #FAFAFA; float:left; margin-left: 10px">Sign Up</h6>
      <button type="button" onclick="closeReg()" class="btn btn-neutral btn-link btn-sm top-margin pull-right">
        <i class="fa fa-times"></i>
      </button>
    </div>

    <div class="contain">
      <form class="form-horizontal" ng-controller="indexCtrl" ng-submit="register()">
        <fieldset>
          <div class="form-group" ng-class="{ 'has-error': userForm.$invalid }">
            <div class="col-lg-12">
              <input class="form-control" ng-model="user.firstName" placeholder="First Name" type="text" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <input class="form-control" ng-model="user.lastName" placeholder="Last Name" type="text" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <input class="form-control" ng-model="user.email" placeholder="Email" type="email" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <input class="form-control" ng-model="user.password" placeholder="Password" type="password" required>
            </div>

          </div>
          <div class="left margin-left">
            <button type="submit" class="btn btn-success">Sign Me Up</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>

</div>

<div class="about-contain">
    <div class="about-info-main">
        <img class="home-2" src="assets/images/woman-2.png" alt="main_icon">
    </div>

    <div class="about-info-main">
        <br>
        <h1 style="color:#34495E;">Organize</h1>
        <br>
        <h6 style="color:#34495E;">Take a glimpse of your day, week or month with Schedulr <br> and easily add tasks according to you</h6>
        <h6 style="color:#34495E;">Collaborate with friends on tasks</h6>
        <h6 style="color:#34495E;">Always be in control</h6>
    </div>
</div>

<div class="about-info bg-yellow">
  <div class="about_image_md">
    <img class="home-2" src="assets/images/main_secondary_3.png" alt="main_icon">
  </div>
  <h1 style="color:#FAFAFA;">Peace of Mind</h1>
  <br>
  <h6 style="color:#FAFAFA;">Give youself more options.<h6> 
  <h6 style="color:#FAFAFA;">Schedulr helps you plan it out </h6>
  <br><br>
  <a class="btn btn-stretch btn-info btn-lg" onClick="openReg()">Sign Up</a>
  <br>
</div>

<div class="about-contain">
    <div class="about-info-main">
        <br>
        <h1 style="color:#34495E;">Relax</h1>
        <br>
        <h6 style="color:#34495E;">Free up your time for the things you enjoy<br> knowing that all your tasks have been completed</h6>
        <h6 style="color:#34495E;">Meaning more time to cook that recipe you've been eyeballin'</h6>
        <h6 style="color:#34495E;">Its that easy!</h6>
    </div>
    
    <div class="about-info-main">
        <img class="home-2" src="assets/images/man.png" alt="main_icon">
    </div>
</div>


<div class="foot_index bg-blue">
  <br>
  <br>
  <center>
    <a href="https://github.com/MarkClinton/Schedulr">
      <span><i style="color:white" class="fa fa-github-square fa-10x"></i>
        <h6 style="color:#FAFAFA;">Github</h6>
      </span>
    </a>
  </center>
</div>
</div>
</div>
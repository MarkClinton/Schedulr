
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

      <div class="image_contain_main">
        <img class="home-main" src="assets/images/home_main_2.png" alt="main_icon">
      </div>

      <div class="mobile_welcome">
        <h1 style="color:white;">Your day? Sorted.</h1>
        <br>
        <h3 style="color:white;">Schedulr helps you keep track of your tasks and events.</h3>
        <h3 style="color:white;">Personal or shared!</h3>
        <h3 style="color:white;">Sign up now to enjoy!</h3>
      </div>

      <div class="mobile_welcome_sml">
        <h6 style="color:white; font-size: 26px;">your day? sorted!</h6>
        <br>
        <h4 style="color:white;">Schedulr helps you keep track of your tasks and events.</h4>
        <h4 style="color:white;">Personal or shared!</h4>
        <h4 style="color:white;">Sign up now to enjoy!</h4>
      </div>

  </div>
  

 <!-- 
  Login popup container
 -->
  <div id = "login" class="login sideNav-index">
    <button type="button" onclick="closeLogin()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
      <i class="fa fa-times"></i>
    </button>
    <div class="contain">
      <h3>Login</h3>
      <form class="form-horizontal" ng-controller="indexCtrl" ng-submit="login()">
        <fieldset>
          <div class="form-group" ng-class="{ 'has-error': userForm.$invalid }" >
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
          <div class="left margin-left top-margin">
            <a href="forgot_password">Forgot Password?</a>   
          </div>
          </fieldset>
        </form> 
      </div>
    </div>

    <!-- 
    Register popup container
    -->
    <div id= "reg" class="sideNav-index reg">
      <button type="button" onclick="closeReg()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
        <i class="fa fa-times"></i>
      </button>
      <div class="contain">
        <h3>Sign Up</h3>
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
              <!--<button type="button" onclick="closeReg()" class="btn btn-danger btn-round">Close</button>-->
            </div>
            </fieldset>
          </form>   
        </div>
      </div>

    </div>

    <div class="about-contain">
      <div class="about_image">
        <img class="home" src="assets/images/home_image_1.png" alt="main_icon">
      </div>

      <div class="about margin-top-index">
        <span><h1 style="color: #5AA3D4; display:inline;">" </h1><h3 style="color:#7A7A7A; display: inline;">Organize your daily tasks. Easily.</h3><h1 style="color: #5AA3D4; display:inline"> "</h1></span>
      </div>

      <div class="about_image">
        <img class="home" src="assets/images/home_2.png" alt="main_icon">
      </div>

      <div class="about">
        <span><h1 style="color: #5AA3D4; display:inline;">" </h1><h3 style="color:#7A7A7A; display: inline;">Add friends and work on projects together.</h3><h1 style="color: #5AA3D4; display:inline"> "</h1></span>
      </div>

      <div class="about_image">
        <img class="home" src="assets/images/home_3.png" alt="main_icon">
      </div>

      <div class="about">
        <span><h1 style="color: #5AA3D4; display:inline;">" </h1><h3 style="color:#7A7A7A; display: inline;">Add files, locations and notes to tasks.</h3><h1 style="color: #5AA3D4; display:inline"> "</h1></span>
      </div>
    </div>

    <div class="about-info bg-gray">
        <div class="about_image_md">
          <img class="home-2" src="assets/images/home_main_secondary.png" alt="main_icon">
        </div>
        <h1 style="color:#7A7A7A;">Peace of mind</h1>
        <br>
        <br>
        <h4 style="color:#7A7A7A;">Schedulr allows a snapshot of your day,
                                  week and month.</h4>
        <h4 style="color:#7A7A7A;">Easily add tasks according 
                                  to your schedule. </h4>
        <br><br>
        <a class="btn btn-stretch btn-info btn-lg" onClick="openReg()">Sign Up</a>
        <br>
        <!--<img class="img-icon-2" src="assets/images/79.png" alt="main_icon">-->
    </div>

    <div class="foot_index bg-blue">
      <br>
      <center><a href="https://github.com/MarkClinton/Schedulr"><span><i style="color:white" class="fa fa-github-square fa-10x"></i><h3 style="color:white;">Github</h3></span></a></center>
    </div>
    </div>
  </div>


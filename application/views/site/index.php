
            <div class="collapse navbar-collapse" id="navbar-success">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item">
                <!--<a class="btn btn-outline-info btn-round" href="<?php echo base_url(); ?>login">Sign In</a>-->

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
      <div class="contain_index_text">
      <br>
      <h1 style="color:white;">Your Day? </h1>
      <h1 style="color:white;">Sorted!</h1>
      <br>
      <h4 style="color:white;">Schedulr helps you keep track of your tasks and events.</h4>
      <h4 style="color:white;">Personal or shared!</h4>
      <h4 style="color:white;">Sign up now to enjoy!</h4>
      <br>
      <!--<a class="btn btn-round btn-outline-info btn-lg" onClick="openReg()">Sign Up</a>-->
      </div>
      <img class="main-icon-img" src="assets/images/33.png" alt="main_icon">

  </div>
  <!--<div class="half-circle">
    <h3>Documentation Download</h3>
  </div>
  

 <!-- 
  Login popup container
 -->
  <div id = "login" class="login sideNav-index">
    <div class="contain">

      <h3>Sign In</h3>
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
      <div class="about">
        <h1 style="color:#7A7A7A;">Whats it all about?</h1>
        <br><br>
        <h4 style="color:#7A7A7A;">Organize your life. Easily.<h4>
        <br>
        <h4 style="color:#7A7A7A;">Schedulr allows a snapshot of your day,
                                  week, month.</h4>
        <h4 style="color:#7A7A7A;">Easily add tasks according 
                                  to your schedule. </h4>
        <br>
        <h4 style="color:#7A7A7A;">Add friends and work together.</h4>
        <br><br>
        <a class="btn btn-stretch btn-info btn-lg" onClick="openReg()">Sign Up</a>
        <br>
        <img class="img-icon-2" src="assets/images/79.png" alt="main_icon">
      </div>
    </div>
  </div>


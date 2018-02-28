
<div class="contain_main">
  <div class="contain_index">
    <h1 style="color:white;">Schedulr.</h1>
    <br>
    <p style="color:white;">Schedulr helps you keep track of your daily tasks, personal or shared.</p>
    <p style="color:white;">Sign up now to enjoy.</p>
    <br>
    <a class="btn btn-round btn-outline-info btn-lg" onClick="openReg()">Sign Up</a>
  </div>
  <div id="overlay-back"></div> 

 <!-- 
  Login popup container
 -->
  <div id = "login" class="login sideNav">
    <div class="contain" ng-app="user">

      <h3>Sign In</h3>
      <br />
      <form class="form-horizontal" ng-controller="loginCtrl" ng-submit="login()">
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
          <div><button type="submit" class="btn btn-outline-success btn-round">Sign In</button>
            <button type="button" onclick="closeLogin()" class="btn btn-outline-danger btn-round">Close</button></div>
          </fieldset>
        </form> 
      </div>
    </div>

    <!-- 
    Register popup container
    -->
    <div id= "reg" class="sideNav reg">
      <div class="contain" ng-app="user">
        <h3>Sign Up</h3>
        <br />
        <form class="form-horizontal" ng-controller="registerCtrl" ng-submit="register()">
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
            <div><button type="submit" class="btn btn-outline-success btn-round">Sign Me Up</button>
              <button type="button" onclick="closeReg()" class="btn btn-outline-danger btn-round">Close</button></div>
            </fieldset>
          </form>   
        </div>
      </div>

    </div>

    <div class="about">
      <h2 style="color:grey;">About.</h2>
      <br>
      <p style="color:grey;">Keep up to date on everything in your life. Easily.</p>
      <p style="color:grey;">Schedulr allows you to view a snapshot of your week or month. Easily add new tasks at a time that suits your schedule. Add friends and work on ideas together.</p>
    </div>
  </div>


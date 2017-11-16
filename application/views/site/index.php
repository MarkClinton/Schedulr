
<div class="contain_main">
  <div class="contain_index">
    <h2 style="color:white;">Get Organized</h2>
    <br>
    <p style="color:whitesmoke;">Schedulr helps you keep track of your daily tasks, personal or shared.</p>
    <p style="color:whitesmoke;">Sign up now to enjoy.</p>
  </div>

  <div class="contain_reg" ng-app="user">
    <h3 style="color:white;">Welcome</h3>
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
        <div><button type="submit" class="btn btn-info btn-round">Register</button></div>
      </fieldset>
    </form>
    
  </div>
</div>
</div>
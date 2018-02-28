

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
      <div><button type="submit" class="btn btn-outline-success btn-round">Sign In</button></div>
    </fieldset>
  </form> 
</div>


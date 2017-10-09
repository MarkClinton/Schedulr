<div class="contain" ng-app="user">
    
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
    <div id="right"><button type="submit" class="btn btn-primary">Sign Me Up</button></div>
  </fieldset>
    </form>
    
    
    
</div>


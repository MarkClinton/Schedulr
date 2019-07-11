  </div>
  </nav>

  <div class="contain-main" ng-app="user">
    <div class="contain">
      <div id="overlay-back"></div>
      <h3>Reset Password</h3>
      <p>Enter your new password.</p>
      <form class="form-horizontal" ng-controller="indexCtrl" ng-submit="validate_recover()">
        <fieldset>

          <div class="form-group" ng-class="{ 'has-error': userForm.$invalid }">
            <div class="col-lg-12">
              <input class="form-control" ng-model="validate.reset_password" placeholder="New Password" type="password" required>
            </div>
          </div>
          <div class="left margin-left top-margin">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
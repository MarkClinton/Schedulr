
  </div>
</nav>

<div class="contain-main" ng-app="user">
  <div class="contain">
    <div id="overlay-back"></div> 
    <h3>Forgot Password</h3>
    <p>Enter email in the field below an well send you a link to update your password.</p>
    <form class="form-horizontal" ng-controller="indexCtrl" ng-submit="recover()">
      <fieldset>

        <div class="form-group" ng-class="{ 'has-error': userForm.$invalid }" >
          <div class="col-lg-12">
            <input class="form-control" ng-model="recover.email" placeholder="Email" type="email" required>
          </div>
        </div>
        <div class="left margin-left top-margin">
          <button type="submit"  class="btn btn-success">Submit</button>
        </div>
      </fieldset>
    </form> 
  </div>
</div>


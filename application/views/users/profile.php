<div class="container">
    <div id="profile_background" ng-app="fetch">
        <div id="profile_contain">
            <div>
                <img class="profile" src="<?php echo base_url() ?>/assets/images/1HFMKW4.jpg" alt="profile" />
                <center><h6>Upload Picture</h6></center>
            </div>

            <div ng-controller="getProfileCtrl">
                <br>
                <table class="table table-striped table-hover ">
                    <tbody ng-repeat="user in profile">
                        <tr>
                            <td>{{user.FIRST_NAME}} {{user.LAST_NAME}}</td>
                        </tr>
                        <tr>
                            <td>{{user.EMAIL}}</td>
                        </tr>
                    </tbody>
                </table> 
            </div>

        </div>

        <div id="profile_dash">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tasks" role="tab">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#friends" role="tab">Friends</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#editProfile" role="tab">Edit Profile</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="tab-content">

                <div class="tab-pane active" id="tasks" role="tabpanel" ng-controller="displayAllCtrl">
                    <md-content class="md-padding" layout-xs="column" layout="row">
    <div flex-xs="" flex-gt-xs="50" layout="column">
      <md-card>
        <img ng-src="{{imagePath}}" class="md-card-image" alt="Washed Out">
        <md-card-title>
          <md-card-title-text>
            <span class="md-headline">Action buttons</span>
          </md-card-title-text>
        </md-card-title>
        <md-card-content>
          <p>
            The titles of Washed Out's breakthrough song and the first single from Paracosm share the
            two most important words in Ernest Greene's musical language: feel it. It's a simple request, as well...
          </p>
          <p>
            The titles of Washed Out's breakthrough song and the first single from Paracosm share the
            two most important words in Ernest Greene's musical language: feel it. It's a simple request, as well...
          </p>
          <p>
            The titles of Washed Out's breakthrough song and the first single from Paracosm share the
            two most important words in Ernest Greene's musical language: feel it. It's a simple request, as well...
          </p>
        </md-card-content>
        <md-card-actions layout="row" layout-align="end center">
          <md-button>Action 1</md-button>
          <md-button>Action 2</md-button>
        </md-card-actions>
      </md-card>
             </div>

                <div class="tab-pane" id="editProfile" role="tabpanel">
                    <div id="edit_contain" ng-controller="updateProfileCtrl" ng-submit="save()">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input class="form-control" ng-model="data.first_name" placeholder="First Name" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input class="form-control" ng-model="data.last_name" placeholder="last Name" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input class="form-control" ng-model="data.email" placeholder="Email" type="text" required readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input class="form-control" ng-model="data.password" placeholder="Password" type="password" required>
                                </div>
                            </div>

                            <div id="right">
                                <button type="submit" class="btn btn-warning btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane" id="friends" role="tabpanel">
                    <div class="friend_search">
                        <input class="input" type="text" name="search" placeholder="Search Friends...">
                        <button type="button" onclick="openNav()" class="btn btn-outline-info btn-just-icon add_person">
                            <i class="fa fa-user-plus fa-lg"></i>
                        </button>
                        
                    </div>

                    <div class="friends" ng-controller="srchPeopleCtrl">
                        <div id="addSidenav" class="sidenav">
                            <button type="button" onclick="closeNav()" class="btn btn-outline-danger btn-just-icon btn-sm top-margin pull-right">
                                <i class="fa fa-times fa-2x"></i>
                            </button>
                            <!--<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>-->
                            <div class="inner_center">
                                <h4>Add Friends</h4>
                                </br>
                                <input class="input2" type="text" ng-model="src.searchText" ng-change="change(text)" placeholder="Search People..." />
                                
                                <div class="srcResults" ng-repeat="entry in entries" ng-hide="!src.searchText.length">
                                    <h4>{{entry.FIRST_NAME}} {{entry.LAST_NAME}}</h4>
                                    <h5>{{entry.EMAIL}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



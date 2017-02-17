
<div id="profile_background" ng-app="fetch">
    <div id="profile_contain">
        <div>
            <img class="profile" src="<?php echo base_url() ?>/assets/images/1HFMKW4.jpg" alt="profile" />
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
        <ul class="nav nav-tabs" id="nav">
            <li class="active"><a href="#tasks" data-toggle="tab" aria-expanded="false">Tasks</a></li>
            <li class=""><a href="#editProfile" data-toggle="tab" aria-expanded="true">Edit Profile</a></li>
            <li class=""><a href="#friends" data-toggle="tab" aria-expanded="false">Friends</a></li>

        </ul>

        <div id="tasks" class="active">
            tasks
        </div>
        <div id="editProfile">

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
        <div id="friends">
            <div class="friend_search">
                <input class="input" type="text" name="search" placeholder="Search Friends...">
                <ul class="nav navbar-right">
                    <a href=""><img class="add_person" onclick="openNav()" src="<?php echo base_url() ?>/assets/images/person_add.png" alt="add"/></a>
                </ul>
            </div>
            <div class="friends" ng-controller="srchPeopleCtrl">
                <div id="addSidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <div class="inner_center">
                        <center><h2>Add Friends</h2></center>
                        <!--<input class="input2" type="text" name="search" placeholder="Search People...">-->
                        <input class="input2" type="text" ng-model="searchText" ng-change="change(text)" placeholder="Search People..." />
                        <li ng-repeat="entry in entries">
                            {{entry.FIRST_NAME}}
                        </li>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


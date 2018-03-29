<div class="container">

    <div id="profile_background" ng-app="fetch">

        <div id="profile_contain" ng-controller="profileCtrl">
            <div id = "profile_image">
                <img class="profile" src="<?php echo base_url() ?>{{img}}" alt="profile" />
            </div>

            <div class="profile_actions">
                <center><a class="btn btn-success btn-link btn-sm" id="ppButton" onClick="pictureUpload()">
                    <i class="fa fa-plus"></i>
                </a></center>
                <div class="sideNav pictureUpload" id="pictureUpload" ng-submit="uploadImage()">
                    <div class="pictureUploadHeader">
                        <center><p>Upload Profile Picture</p></center>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <br>
                        <input type="file" id="imageField" file-model="imageFile" name ="file">
                        <input type="submit" value = "Upload">
                    </form>

                </div>
            </div>

            <div id = "profile_info">
                <div ng-repeat="user in profile">
                    <center><h5>{{user.FIRST_NAME}} {{user.LAST_NAME}}</h5></center>
                    <center><p>{{user.EMAIL}}</p></center>
                </div>
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

                    <div id="center_div" ng-controller="displayAllCtrl" ng-cloak>
                        <div ng-repeat="tasks in allTasks" >

                            <div class= "card">
                                <div class="taskHead card_task">
                                    <h5 ng-click="showTask(tasks)">{{tasks.TASK_NAME}} </h5>
                                </div>
                                <div class="taskDetails">
                                    <p> </p>
                                    <p>{{tasks.TASK_DATE | date}} </p>
                                    <p>{{tasks.START_TIME}}</p>
                                    <p>{{tasks.TASK_INFO}} </p>
                                </div>
                            </div>

                        </div>
                    </div>


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

                            <div id="center">
                                <button type="submit" class="btn btn-success btn-round">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane" id="friends" role="tabpanel">
                     <div class="friend_search">
                        <!--<input class="input" type="text" name="search" placeholder="Search Friends...">-->
                        <div id="overlay-back"></div> 
                        <button type="button" onclick="openNav()" class="btn btn-info btn-link add_person">
                            <i class="fa fa-user-plus"></i>
                        </button>

                    </div>

                    <div class="user_friends" ng-controller="showFriendsCtrl">
                        <div ng-repeat="friend in friends">
                            <div class="friend_layout">
                                <img class="user profile " src="<?php echo base_url() ?>{{friend.URL}}" alt="profile" />
                                <p>{{friend.FIRST_NAME}} {{friend.LAST_NAME}}</p>
                                <p>{{friend.EMAIL}}</p>
                                <button type="button" ng-click="removeFriend(friend.ID)" class="btn btn-danger btn-link btn-sm">
                                <i class="fa fa-times"></i>
                            </button>

                            </div>
                        </div>
                    </div>

                    <div class="friends" ng-controller="srchPeopleCtrl">
                        <div id="addSidenav" class="sidenav">
                            <button type="button" onclick="closeNav()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                                <i class="fa fa-times"></i>
                            </button>
                            <!--<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>-->
                            <div class="inner_center">
                                <h4>Add Friends</h4>
                            </br>
                            <input class="input2" type="text" ng-model="src.searchText" ng-change="change(text)" placeholder="Search People..." />

                            <div class="srcResults" ng-repeat="entry in entries" ng-hide="!src.searchText.length">
                                <img class="user search profile" src="<?php echo base_url() ?>{{entry.URL}}" alt="profile" />
                                <button type="button" style="float:right;" ng-click="addFriend(entry.ID)" class="btn btn-success btn-link btn-sm">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <p>{{entry.FIRST_NAME}} {{entry.LAST_NAME}}</p>
                                <p>{{entry.EMAIL}}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



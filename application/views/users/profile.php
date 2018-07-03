<div class="container">

    <div id="profile_background" ng-app="fetch">

        <div id="profile_contain" ng-controller="profileCtrl">
            <div id = "profile_image">
                <img class="profile" src="<?php echo base_url() ?>{{img}}" alt="profile" />
            </div>

            <div class="profile_actions">
                <center><button class="btn btn-success btn-link btn-sm" id="ppButton" onClick="pictureUpload()">
                    <i class="fa fa-plus"></i>
                </button></center>
                <div class="sideNav-index pictureUpload" id="pictureUpload" ng-submit="uploadImage()">
                    <div class="pictureUploadHeader">
                        <center><p>Upload Profile Picture</p></center>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="upload">
                            <label class="upload-label">
                                <h6 style="color: #FFFFFF">Browse </h6>
                                <input type="file" id="imageField" 
                                onchange="$('#upload-file-info').html(this.files[0].name)" 
                                file-model="imageFile" name ="file" hidden>
                            </label>
                            <span class="upload-file-text" id="upload-file-info"></span>
                        </div>
                        
                        <br>
                        <center>
                            <input type="submit" class="btn btn-success btn-sm" value="Change">
                        </center>
                    </form>

                </div>
            </div>

            <div id = "profile-info">
                    
                        <div id="user-details-mobile" class="top-pad">
                            <h5>{{profile.first_name}} {{profile.last_name}}</h5>
                            <p>{{profile.email}}</p>
                        </div>

                        <div id="user-details-mobile" class="mob-left">
                            <p ng-if="details.friends > 1">{{details.friends}} Friends</p>
                            <p ng-if="details.friends == 1">{{details.friends}} Friend</p>
                            <p>{{details.tasks}} Tasks</p>
                            <p ng-if="details.groups > 1">{{details.groups}} Groups</p>
                            <p ng-if="details.groups == 1">{{details.groups}} Group</p>
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
                            <a class="nav-link" data-toggle="tab" href="#editProfile" role="tab">Profile</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="tab-content">

                <div class="tab-pane active" id="tasks" role="tabpanel">

                    <div id="center_div" ng-controller="displayUserCtrl" ng-cloak>
                        <div ng-repeat="tasks in userTasks" >

                            <div class= "card ">
                                <div ng-class="taskColor(tasks.type)" class="taskHead">
                                    <h5 class="white" ng-click="showTask(tasks)">{{tasks.name}} </h5>
                                </div>
                                <div class="taskDetails">
                                    <p> </p>
                                    <p>{{tasks.task_date | date : 'dd MMM'}} @ {{tasks.start_time}} </p>
                                    <!--<p>{{tasks.start_time}}</p>-->
                                    <p>{{tasks.info}} </p>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <div class="tab-pane" id="editProfile" role="tabpanel">
                    <div id="edit_contain" ng-controller="updateProfileCtrl" ng-submit="save()">
                        <div class="profile_edit">

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

                            

                            <div class="left margin-left">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>

                        <div class="left margin-left top-margin">
                            <a onClick="showUpdatePassword()">Update Password</a>   
                        </div>
                        
                        </div>


                        <div class="timeline">

                            <div ng-repeat="t in timeline | limitTo:10" >
                                <p><span class="links">{{t.created_at | date : 'dd MMM'}}</span>
                                {{t.name}}
                                <span class="green">{{t.timeline}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="overlay-back"></div> 

                <div class="pop-contain">
                    <div id="update_password" class="sideNav" ng-controller="updateProfileCtrl" ng-submit="updatePword()">

                        <button type="button" onclick="closeUpdatePassword()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                            <i class="fa fa-times"></i>
                        </button>

                        <div class="inner_center">
                            <h3>Update Password</h3>

                            <form class="form-horizontal">

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input class="form-control" ng-model="update.password_old" placeholder="Current Password" type="password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input class="form-control" ng-model="update.password_new" placeholder="New Password" type="password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input class="form-control" ng-model="update.password_new_confirm" placeholder="Confirm New Password" type="password" required>
                                    </div>
                                </div>

                                <div class="left margin-left">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="friends" role="tabpanel">
                     <div class="friend_search">
                        <!--<input class="input" type="text" name="search" placeholder="Search Friends...">-->
                        <div id="overlay-back"></div> 
                        <!--<button type="button" onclick="openNav()" class="btn btn-info btn-link add_person">
                            
                        </button>-->
                        <button type="button" onclick="openNav()" class="btn btn-success btn-sm add_person">
                            <i class="fa fa-user-plus"></i>
                            <!--<h6>Add Friend</h6>-->
                        </button>


                    </div>

                    <div class="user_friends" ng-controller="showFriendsCtrl">
                        <div ng-repeat="friend in friends">
                            <div class="friend_layout">
                                <img class="user profile " src="<?php echo base_url() ?>{{friend.img_url}}" alt="profile" />
                                <div class="left">
                                <h5>{{friend.first_name}} {{friend.last_name}}</h5>
                                <div class="email"><p>{{friend.email}}</p></div>
                                </div>
                                <button type="button" ng-click="removeFriend(friend.id)" class="btn btn-sm2 btn-danger top-sm pull-right">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>

                            </div>
                        </div>
                    </div>

                    <div class="friends" ng-controller="srchPeopleCtrl">
                        <div id="addFriend" class="sidenav">
                            <button type="button" ng-click="remove()" onclick="closeNav()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                                <i class="fa fa-times"></i>
                            </button>
                            <!--<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>-->
                            <div class="inner_center">
                                <center><h3>Add Friends</h3></center>
                            </br>
                            <input class="input2" id="searchInput" type="text" ng-model="src.searchText" ng-change="change(text)" placeholder="Search By Email.." />

                            <div class="srcResults" ng-repeat="entry in entries" ng-hide="!src.searchText.length">
                                <img class="user search profile" src="<?php echo base_url() ?>{{entry.img_url}}" alt="profile" />

                                <button ng-show="entry.status == 1" type="button" style="float:right;cursor:default" class="btn btn-primary btn-link btn-sm">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>

                                <button ng-show="entry.status == 2" type="button" style="float:right; cursor:default" class="btn btn-primary btn-link btn-sm">
                                    <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                                </button>

                                <button ng-show="entry.status == 4 || entry.status == null" type="button" style="float:right;" ng-click="addFriend(entry.id)" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>

                                <p>{{entry.first_name}} {{entry.last_name}}</p>
                                <p>{{entry.email}}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<div class="container" ng-app="task">
    <div class="bg-index">
        <div class='viewTask' ng-controller="taskCtrl">

            <div class="taskBoard">
                <div class="taskViewHead">
                    <!--<a class="btn btn-success btn-sm pull-right" >Add <i class="fa fa-caret-down"></i></a>-->


                    <div class="nav-item dropdown">
                    <!--<a class="nav-link dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" href="#pk" role="button" aria-haspopup="true" aria-expanded="false">
                        Add <i class="fa fa-caret-down"></i>
                    </a>-->
                    <a class="btn btn-success btn-sm pull-right" data-toggle="dropdown" href="#pk" role="button" aria-haspopup="true" aria-expanded="false">
                        Add <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu file dropdown-info" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" onClick="showNote()">Note</a>
                        <a class="dropdown-item" onClick="showFile()">File</a>
                        <a class="dropdown-item" onClick="showLocation()">Location</a>
                    </ul>
                </div>

            </div>
            <div class="task-view-main" map-lazy-load="https://maps.google.com/maps/api/js?key=AIzaSyAKGQaIHaiRawx9GHR2CgzsGptwWdiNv2w">
                <div ng-repeat="m in data.media" >
                    <div class= "card card-plain card-task">
                        <div class="task-main">
                            
                            <div ng-show="m.type == 1" class="task-body">
                                <h6>{{m.information}} </h6>
                            </div>

                            <div ng-show="m.type == 2" class="mediaMap">
                                <ng-map center="{{m.lat}},{{m.lng}}" zoom="14">
                                    <marker position="{{m.lat}},{{m.lng}}" />
                                </ng-map>
                            </div>

                            <div ng-show="m.type == 3" class="task-file">
                                <a href="<?php echo base_url() ?>{{m.file_url}}" target="_blank">
                                    <img ng-show="isImage(m.information)" class="file" src="<?php echo base_url() ?>{{m.file_url}}" alt="download"/>
                                </a>

                                <div ng-show="isImage(m.information) === false">
                                    <a href="<?php echo base_url() ?>{{m.file_url}}" target="_blank">
                                        <img class="file-down" src="<?php echo base_url() ?>assets/images/download (1).png" alt="profile"/>
                                    </a>
                                    <br>
                                    <h6>{{m.information}}</h6>
                                </div>
                            </div>

                            <div class="task-footer">
                                <img class="smlr profile pull-left margin-left-5" src="<?php echo base_url() ?>{{m.img_url}}" alt="profile" title="{{m.first_name}}"/>
                                <span ng-show="createdBy(m.user_id) || isAdmin()"><button type="button" ng-click="deleteMedia(m.id)" class="btn btn-danger btn-link btn-sm top-margin-delete pull-right">
                                    <i class="fa fa-times"></i>
                                </button></span>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Map testing-->

            <div class="pop-contain">
                <div id="locationAdd" class="sideNav" >
                    <div id="map" class="map"></div>
                    <div class="left top-margin margin-left">
                        <button ng-click="addLocation()" class="btn btn-stretch-2 btn-success btn-sm">Add</button>
                    </div>
                </div>
            </div>

            <!-- End Of map testing-->


            <div class="pop-contain">
                <div id="note" class="sideNav" >
                    <button type="button" onclick="closeNote()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="inner_center">
                        <h3>Add New Note</h3>

                        <form name="saveTaskData" class="form-horizontal" ng-submit="addNote()"> 
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    
                                    <textarea class="form-control note" id="noteTextArea" ng-model="note.info" placeholder="New Note..." type="text" maxlength="200" required></textarea>
                                    <p>200 Character Limit</p>

                                    <div class="left top-margin">
                                        <button type="submit" class="btn btn-stretch-2 btn-success btn-sm">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="pop-contain">
                <div id="fileUp" class="sideNav" >
                    <button type="button" onclick="closeFile()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="inner_center">
                        <h3>Add New File</h3>

                        <form method="POST" enctype="multipart/form-data" ng-submit="addFile()">
                            <br>
                            <div class="uploadFile">
                                <label class="upload-label">
                                    <h6 style="color: #FFFFFF">Browse </h6>
                                    <input type="file" id="imageField" 
                                    onchange="$('#upload-file-task').html(this.files[0].name)" 
                                    file-model="imageFile" name ="file" hidden>
                                </label>
                                <span class="upload-file-text" id="upload-file-task"></span>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-success btn-sm" value="Upload">
                        </form>

                    </div>
                </div>
            </div>

            <div id="overlay-back"></div> 

            <div class="friends">
                <div id="addUser" class="sideNav" >
                    <button type="button" onclick="closeAddUser()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="inner_center">
                        <h3>Add Friend To Project</h3>
                        <br>

                        <div class="srcResults" ng-show="data.friends == null || data.friends.length == 0">
                            <p>All of your friends are already added to this task!</p>
                        </div>

                        <div class="srcResults" ng-repeat="friend in data.friends">
                            <img class="search profile" src="<?php echo base_url() ?>{{friend.img_url}}" alt="profile" />
                            <button type="button" style="float:right;" ng-click="addUsers(friend.id)" class="btn btn-success btn-link btn-sm">
                                <i class="fa fa-plus"></i>
                            </button>
                            <p>{{friend.first_name}} {{friend.last_name}}</p>
                            <p>{{friend.email}}</p>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>


        <div class="taskSideContain">
            <div class="taskHeader">
                <div class="circle-2 left" ng-class="taskColor(data.admin.type)"></div>
                <h3 class="bolder">{{data.admin.name}}</h3>
            </div>

            <div class='taskSideBar'>
                <p>{{data.admin.info}}</p>
                <p>{{data.admin.task_date}}</p>
                <!--{{ isAdmin() == true ? 'You' : data.admin.first_name }}-->
                <br>
                <p>Created By 
                    <span ng-show="isAdmin()" class="green" >You</span>
                    <span ng-hide="isAdmin()"class="green" >{{data.admin.first_name}}</span>
                </p>
                <!--<img class="smlr profile " src="<?php echo base_url() ?>{{data.admin.img_url}}" alt="profile" title="{{data.admin.first_name}}"/>-->
                        <br>
                        <p>Shared With
                            <span><a ng-show="isAdmin()" class="btn btn-success btn-link btn-sm add" id="ppButton" onClick="showAddUser()" title="Add New User">
                                <i class="fa fa-plus"></i>
                            </a></span></p>
                            <div ng-repeat="data in data.share">
                                <div class="par_layout">
                                    <img class="smlr profile " src="<?php echo base_url() ?>{{data.img_url}}" title="{{data.first_name}}" alt="profile" />
                                </div>
                            </div>
                            <!--<img class="sml add profile " src="<?php echo base_url() ?>/assets/images/add.png" title="Add New User"/>-->
                        </div>
                    </div>
                </div> 
            </div>

        </div>

<!--<div class="containTask" ng-app="task">
    <form name="saveTaskData" ng-controller="taskCtrl" ng-submit="update()">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Update Task</h3>
            </div>
       
            <div class="panel-body">
                <p><input class="form-control" ng-model="data.inputTaskName" type="text" required></p>
                <p><input ui-timepicker class="form-control" ng-model="data.inputTaskStart" id="selector" type="text" required></p>
                <p><input ui-timepicker class="form-control" ng-model="data.inputTaskEnd" id="selector2" type="text" required></p>
                
                <p><datepicker date-format="yyyy-MM-dd"><input class="form-control" ng-model="data.inputTaskDate" type="text" required></datepicker></p>
                
                <p><textarea class="form-control" ng-model="data.inputTaskInfo" type="text" required></textarea></p>
                
                <div id="right"><button type="submit" class="btn btn-warning btn-sm">Update</button></div>
            </div>
        </div>
        </form>
    </div>   


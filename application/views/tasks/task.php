<div class="container" ng-app="task">
    <div class="bg-index">
        <div class='viewTask' ng-controller="taskCtrl">
            <div id="overlay-back"></div>

            <div class="mobile_task_info">

                <div class="taskHeader">
                    <div class="circle-2 left" ng-class="taskColor(data.admin.type)"></div>
                    <h3 class="bolder">{{data.admin.name}}</h3>
                </div>

                <div class='taskSideBar'>
                    <p>{{data.admin.info}}</p>
                    <p>{{data.admin.task_date}}</p>
                    <p>Created By
                        <span ng-show="isAdmin()" class="green">You</span>
                        <span ng-hide="isAdmin()" class="green">{{data.admin.first_name}}</span>
                    </p>
                    <p>Shared With
                        <span><a ng-show="isAdmin()" class="btn btn-success btn-link btn-sm add" id="ppButton" onClick="showAddUser()" title="Add New User">
                                <i class="fa fa-plus"></i>
                            </a></span></p>
                    <div ng-repeat="data in data.share">
                        <div class="par_layout">
                            <img class="smlr profile " src="<?php echo base_url() ?>{{data.img_url}}" title="{{data.first_name}}" alt="profile" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="taskBoard">
                <div id='updateTask' class="sidenav_big">
                    <button type="button" onclick="closeUpdate()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="form-create-task margin-left-1">
                        <h5 style="text-align: left;">Edit Task</h5>

                        <form name="saveTaskData" class="form-horizontal" ng-submit="submit()">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <input class="form-control" ng-model="data.admin.name" placeholder="Task Name" type="text" required>

                                    <input ui-timepicker class="form-control-2" ng-model="data.admin.start_time" placeholder="Task Start Time" id="selector_start_update" type="text" required>
                                    <span class="contain_text_middle">
                                        <h4>until</h4>
                                    </span>
                                    <input ui-timepicker class="form-control-2 fc2-left" ng-model="data.admin.end_time" placeholder="Task End Time" id="selector_end_update" type="text" required>

                                    <input style="display: none !important;" class="form-control" ng-model="data.sharedWith" type="text" id="datepicker">

                                    <datepicker date-format="yyyy-MM-dd"><input class="form-control" ng-model="data.admin.task_date" placeholder="Task Date" type="text" required></datepicker>
                                    <br>

                                    <select class="form-control" ng-model="data.admin.typename" ng-options="type as type.value for type in data.types" required>
                                        <!--<option value="" disabled selected>Choose Type</option>-->
                                    </select>

                                    <textarea class="form-control" ng-model="data.admin.info" placeholder="Task Information" type="text" required></textarea>
                                    <br>
                                    <div id="left">
                                        <button type="submit" class="btn btn-stretch-2 btn-success btn-sm">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="share-create-task no-margin-right margin-left-2">
                        <div class="create-share-friends">
                            <h5 style="text-align: left;">Remove Share (Click on Image)</h5>
                            <div ng-show="data.share == null || data.share.length == 0">
                                <p>No one added to task</p>
                            </div>
                            <div ng-repeat="data in data.share">
                                <div class="par_layout">
                                    <img class="smlr profile " ng-click="removeFromShare(data.id)" src="<?php echo base_url() ?>{{data.img_url}}" title="{{data.first_name}}" alt="profile" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



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

                    <a ng-show="isAdmin()" class="btn btn-info btn-sm pull-left" role="button" onclick="openUpdate()">
                        Edit <i class="fa fa-edit"></i>
                    </a>

                </div>
                <div class="task-view-main" map-lazy-load="https://maps.google.com/maps/api/js?key=AIzaSyAKGQaIHaiRawx9GHR2CgzsGptwWdiNv2w">
                    <div ng-repeat="m in data.media">
                        <div class="card card-plain card-task">
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
                                        <img ng-show="isImage(m.information)" class="file" src="<?php echo base_url() ?>{{m.file_url}}" alt="download" />
                                    </a>

                                    <div ng-show="isImage(m.information) === false">
                                        <a href="<?php echo base_url() ?>{{m.file_url}}" target="_blank">
                                            <img class="file-down" src="<?php echo base_url() ?>assets/images/download (1).png" alt="profile" />
                                        </a>
                                        <br>
                                        <h6>{{m.information}}</h6>
                                    </div>
                                </div>

                                <div class="task-footer">
                                    <img class="smlr profile pull-left margin-left-5" src="<?php echo base_url() ?>{{m.img_url}}" alt="profile" title="{{m.first_name}}" />
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
                    <div id="locationAdd" class="sideNav">
                        <div id="map" class="map"></div>
                        <div class="left top-margin margin-left">
                            <button ng-click="addLocation()" class="btn btn-stretch-2 btn-success btn-sm">Add</button>
                        </div>
                    </div>
                </div>

                <!-- End Of map testing-->


                <div class="pop-contain">
                    <div id="note" class="sideNav">
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
                    <div id="fileUp" class="sideNav">
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
                                        <input type="file" id="imageField" onchange="$('#upload-file-task').html(this.files[0].name)" file-model="imageFile" name="file" hidden>
                                    </label>
                                    <span class="upload-file-text" id="upload-file-task"></span>
                                </div>
                                <br>
                                <input type="submit" class="btn btn-success btn-sm" value="Upload">
                            </form>

                        </div>
                    </div>
                </div>



                <div class="friends">
                    <div id="addUser" class="sideNav">
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
                        <span ng-show="isAdmin()" class="green">You</span>
                        <span ng-hide="isAdmin()" class="green">{{data.admin.first_name}}</span>
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
<div class="container" ng-app="task">

    <div class='viewTask' ng-controller="taskCtrl">

        <div class="taskBoard">
            <div class="taskViewHead">

            </div>

            <div id="overlay-back"></div> 
            <div class="friends" ng-controller="getFriendsCtrl">
            <div id="addSidenav" class="sideNav" >
                <button type="button" onclick="closeNav()" class="btn btn-danger btn-link btn-sm top-margin pull-right">
                    <i class="fa fa-times"></i>
                </button>
                <div class="inner_center">
                    <h5>Add Friend To Project</h5>
                <br>
                <div class="srcResults" ng-repeat="friends in friend">
                    <img class="search profile" src="<?php echo base_url() ?>{{friends.URL}}" alt="profile" />
                    <button type="button" style="float:right;" ng-click="addUsers(friends.ID)" class="btn btn-success btn-link btn-sm">
                        <i class="fa fa-plus"></i>
                    </button>
                    <p>{{friends.FIRST_NAME}} {{friends.LAST_NAME}}</p>
                    <p>{{friends.EMAIL}}</p>
                    

                </div>
            </div>
            </div>

        </div>

            

        </div>


        <div class="taskSideContain">
            <div class="taskHeader">
                <h5>{{data.admin.TASK_NAME}}</h5>
                <p>{{data.admin.TASK_DATE}}</p>
                <p>{{data.admin.TASK_INFO}}</p>

            </div>

            <div class='taskSideBar'>
                <br>
                <p>Admin</p>
                <img class="sml profile " src="<?php echo base_url() ?>{{data.admin.url}}" alt="profile" title="{{data.admin.first_name}}"/>
                <!--<p ng-if="data.admin.ADMIN == data.admin.USER_ID">You</p>
                <p ng-if="data.admin.ADMIN != data.admin.USER_ID">{{data.admin.first_name}}}</p>-->
                <br>
                <p>Participants</p>
                <div ng-repeat="data in data.share | filter: isAdmin">
                    <div class="par_layout">
                        <img class="sml profile " src="<?php echo base_url() ?>{{data.url}}" title="{{data.FIRST_NAME}}" alt="profile" />
                    </div>
                </div>
                <!--<img class="sml add profile " src="<?php echo base_url() ?>/assets/images/add.png" title="Add New User"/>-->
                <a class="btn btn-success btn-link btn-sm add" id="ppButton" onClick="showAddUser()" title="Add New User">
                    <i class="fa fa-plus"></i>
                </a>

                


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


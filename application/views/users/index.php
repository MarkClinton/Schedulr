
<div class="container" ng-app="fetch">

    <div id="dashboard">
        <ul class="nav nav-tabs" id="nav">
            <li class="active"><a href="#mytasks" data-toggle="tab" aria-expanded="true"><h4>Upcoming</h4></a></li>
            <!--<li class=""><a href="#grouptasks" data-toggle="tab" aria-expanded="true">Group Tasks</a></li>-->


            <ul class="nav navbar-right">
                <li><a href="tasks/create"><img class="add" src="<?php echo base_url()?>/assets/images/add.png" alt="add"></img></a></li>
            </ul>
        </ul>
        <div id="mytasks" class="active" >
            <div ng-controller="displayUserCtrl" ng-cloak>
                <div ng-repeat="tasks in userTasks | limitTo: 5" >
                    <div class= "upcomingTasks">
                        <div class="upcomingHead">
                            <h4 style="float: left" ng-click="showTask(tasks)">{{tasks.TASK_NAME}} </h4>
                            <button style="float: right" class="btn btn-danger btn-sm" ng-click="delete(tasks, $index)">Delete</button>
                        </div>
                        <div class="upcomingDetails">
                            <h6> {{tasks.TASK_DATE | date}} @ {{tasks.START_TIME}} </h6>
                            <h6> {{tasks.TASK_INFO}} </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<div id="grouptasks" >
            <div ng-controller="displayGroupCtrl" ng-cloak>
                <table class="table table-striped table-hover ">
                    <tbody>   
                        <tr ng-repeat="tasks in groupTasks">
                            <td ng-click="showGroupTask(tasks)">{{tasks.TASK_NAME}}</td>
                            <td ng-click="showGroupTask(tasks)">{{tasks.START_TIME}}</td>
                            <td ng-click="showGroupTask(tasks)">{{tasks.TASK_DATE}}</td>
                            <td ng-click="showGroupTask(tasks)">{{tasks.TASK_INFO}}</td>
                            <td><button class="btn btn-danger btn-sm" ng-click="delete(tasks, $index)">Delete</button></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>-->
    </div>


    <div id="calendar">
        
    </div>
    
    
</div>
</div>


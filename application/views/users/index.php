
<div class="container" ng-app="fetch">


    <div id="dashboard">
        <ul class="nav nav-tabs" id="nav">
            <li class="active"><a href="#mytasks" data-toggle="tab" aria-expanded="true">My Tasks</a></li>
            <li class=""><a href="#grouptasks" data-toggle="tab" aria-expanded="true">Group Tasks</a></li>


            <ul class="nav navbar-right">
                <li><a href="tasks/create"><img class="add" src="<?php echo base_url()?>/assets/images/add.png" alt="add"/></a></li>
            </ul>
        </ul>

        <div id="mytasks" class="active">
            <div ng-controller="displayUserCtrl">
                <table class="table table-striped table-hover ">
                    <tbody>   
                        <tr ng-repeat="tasks in userTasks">
                            <td ng-click="showTask(tasks)">{{tasks.TASK_NAME}}</td>
                            <td ng-click="showTask(tasks)">{{tasks.START_TIME}}</td>
                            <td ng-click="showTask(tasks)">{{tasks.TASK_DATE}}</td>
                            <td ng-click="showTask(tasks)">{{tasks.TASK_INFO}}</td>
                            <td><button class="btn btn-danger btn-sm" ng-click="delete(tasks)">Delete</button></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>

        <div id="grouptasks" >
            <div ng-controller="displayGroupCtrl">
                <table class="table table-striped table-hover ">
                    <tbody>   
                        <tr ng-repeat="tasks in groupTasks">
                            <td ng-click="showGroupTask(tasks)">{{tasks.TASK_NAME}}</td>
                            <td ng-click="showGroupTask(tasks)">{{tasks.START_TIME}}</td>
                            <td ng-click="showGroupTask(tasks)">{{tasks.TASK_DATE}}</td>
                            <td ng-click="showGroupTask(tasks)">{{tasks.TASK_INFO}}</td>
                            <td><button class="btn btn-danger btn-sm" ng-click="delete(tasks)">Delete</button></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>

    <div id="recents">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Upcoming Tasks</h3>
            </div>
            <div class="panel-body">
                <div ng-controller="displayUpcomingCtrl">
                    <table class="table table-striped table-hover ">
                        <tbody>   
                            <tr ng-repeat="tasks in upcomingTasks" ng-click="showUpcomingTask(tasks)">
                                <td>{{tasks.TASK_NAME}}</td>
                                <td>{{tasks.START_TIME}}</td>
                                <td>{{tasks.TASK_DATE}}</td>
                            </tr>
                        </tbody>
                    </table>   
                    <modal visible="showModal">
                    
                        WHATEVER
                    </modal>
                </div> 
            </div>
        </div>
    </div>
    
    
</div>
</div>


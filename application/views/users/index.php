
<div class="container" ng-app="fetch">

    <div id="dashboard" class="margined-top">

        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <ul id="tabs" class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#upcoming" role="tab">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#all" role="tab">My Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#group" role="tab">Group Tasks</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content text-left">
            <div class="tab-pane active" id="upcoming" role="tabpanel">
                <div ng-controller="displayUserCtrl" ng-cloak>
                    <div ng-repeat="tasks in userTasks | limitTo : 5" >
                        <div class= "tasks">
                            <div class="taskHead">
                                <h5 style="float: left; font-weight: 500;" ng-click="showTask(tasks)">{{tasks.TASK_NAME}} </h5>
                                <button style="float: right" class="btn btn-danger btn-link btn-sm" ng-click="delete(tasks)"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="taskDetails">
                                <p> </p>
                                <p>{{tasks.TASK_DATE | date}} @ {{tasks.START_TIME}}</p>
                                <p> {{tasks.TASK_INFO}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="all" role="tabpanel">
                <div ng-controller="displayAllCtrl" ng-cloak>
                    <div ng-repeat="tasks in allTasks" >
                        <div class= "tasks">
                            <div class="taskHead">
                                <h5 style="float: left; font-weight: 500;" ng-click="showTask(tasks)">{{tasks.TASK_NAME}} </h5>
                                <button style="float: right" class="btn btn-danger btn-link btn-sm" ng-click="delete(tasks)"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="taskDetails">
                                <p> </p>
                                <p>{{tasks.TASK_DATE | date}} @ {{tasks.START_TIME}}</p>
                                <p> {{tasks.TASK_INFO}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="group" role="tabpanel">
                <div ng-controller="displayGroupCtrl" ng-cloak>  
                    <div ng-repeat="tasks in groupTasks">
                        <div class= "tasks">
                            <div class="taskHead">
                                <h5 style="float: left; font-weight: 500;" ng-click="showTask(tasks)">{{tasks.TASK_NAME}} </h5>
                                <button style="float: right" class="btn btn-danger btn-link btn-sm" ng-click="delete(tasks)"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="taskDetails">
                                <p> </p>
                                <p>{{tasks.TASK_DATE | date}} @ {{tasks.START_TIME}}</p>
                                <p> {{tasks.TASK_INFO}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="calendar" class="margined-top">

    </div>


</div>
</div>


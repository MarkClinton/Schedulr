
<div class="container" ng-app="fetch">
    <div class="bg-index">
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
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#expired" role="tab">Past Tasks</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content text-left">
                <div class="tab-pane active" id="upcoming" role="tabpanel">
                    <div ng-controller="displayUserCtrl" ng-cloak>

                        <div ng-repeat="tasks in filteredTasks = (userTasks| filter: filterByDate)">
                            <div class= "tasks">
                                <div class="taskHead">
                                    <div class="circle left" ng-class="taskColor(tasks.type)"></div>
                                    <h5 style="float: left;" ng-click="showTask(tasks)">{{tasks.name}} </h5>
                                    <div ng-show="isAdmin(tasks.user_id)">
                                        <button style="float: right" class="btn btn-danger btn-link btn-sm" ng-click="delete(tasks)"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="taskDetails">
                                    <p> </p>
                                    <p>{{tasks.task_date | date : 'dd MMM'}} @ {{tasks.start_time}}</p>
                                    <p> {{tasks.info}} </p>
                                </div>
                            </div>
                        </div>

                        <div class="no-tasks" ng-show="filteredTasks.length == 0">
                            <p>No tasks to display</p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="expired" role="tabpanel">
                    <div ng-controller="displayUserCtrl" ng-cloak>

                        <div ng-repeat="tasks in filteredExpired = (userTasks | filter: filterByExpired)">
                            <div class= "tasks">
                                <div class="taskHead">
                                    <div class="circle left" ng-class="taskColor(tasks.type)"></div>
                                    <h5 style="float: left;" ng-click="showTask(tasks)">{{tasks.name}} </h5>
                                    <div ng-show="isAdmin(tasks.user_id)">
                                        <button style="float: right" class="btn btn-danger btn-link btn-sm" ng-click="delete(tasks)"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="taskDetails">
                                    <p> </p>
                                    <p>{{tasks.task_date | date : 'dd MMM'}} @ {{tasks.start_time}}</p>
                                    <p> {{tasks.info}} </p>
                                </div>
                            </div>
                        </div>

                        <div class="no-tasks" ng-show="filteredExpired.length == 0">
                            <p>No expired tasks</p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="all" role="tabpanel">
                    <div ng-controller="displayAllCtrl" ng-cloak>

                        <div ng-repeat="tasks in filteredAll = (allTasks | filter: filterByDate)" >
                            <div class= "tasks">
                                <div class="taskHead">
                                    <div class="circle left" ng-class="taskColor(tasks.type)"></div>
                                    <h5 style="float: left;" ng-click="showTask(tasks)">{{tasks.name}} </h5>
                                    <div ng-show="isAdmin(tasks.user_id)">
                                        <button style="float: right" class="btn btn-danger btn-link btn-sm" ng-click="delete(tasks)"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="taskDetails">
                                    <p> </p>
                                    <p>{{tasks.task_date | date : 'dd MMM'}} @ {{tasks.start_time}}</p>
                                    <p> {{tasks.info}} </p>
                                </div>
                            </div>
                        </div>

                        <div class="no-tasks" ng-show="filteredAll.length == 0">
                            <h4 style="text-align: center">No active current tasks</h4>
                        </div>

                    </div>
                </div>

                <div class="tab-pane" id="group" role="tabpanel">
                    <div ng-controller="displayGroupCtrl" ng-cloak> 

                        <div ng-repeat="tasks in filteredGroup = (groupTasks | filter: filterByDate)">
                            <div class= "tasks">
                                <div class="taskHead">
                                    <div class="circle left" ng-class="taskColor(tasks.type)"></div>
                                    <h5 style="float: left;" ng-click="showTask(tasks)">{{tasks.name}} </h5>
                                </div>
                                <div class="taskDetails">
                                    <p> </p>
                                    <p>{{tasks.task_date | date : 'dd MMM'}} @ {{tasks.start_time}}</p>
                                    <p> {{tasks.info}} </p>
                                </div>
                            </div>
                        </div>

                        <div class="no-tasks" ng-show="filteredGroup.length == 0">
                            <h4 style="text-align: center">You are not added to any active group tasks</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div id="calendar" class="margined-top">

        </div>

        <div class="information-contain">
            <div class="circle task-meeting"></div>
            <div class="inline"><h5>Meeting</h5></div>
            <div class="circle task-event"> </div>
            <div class="inline"><h5>Event</h5></div>
            <div class="circle task-personal"> </div>
            <div class="inline"><h5>Personal</h5></div>
            <div class="circle task-work"> </div>
            <div class="inline"><h5>Work</h5></div>
        </div>

    </div>
</div>
</div>


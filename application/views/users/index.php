<div class="container" ng-app="fetch">
    <div class="bg-index">
        <div id="dashboard" class="margined-top">

            <div id="overlay-back"></div>

            <div id='updateTask' class="sidenav_med" ng-controller="calendarCtrl" ng-submit="submit()" ngCloak>
                <div class="nav-header">
                <h6 class="top-margin" style="color: white; float:left; margin-left: 10px">Quick Create</h6>
                    <button type="button" onclick="closeUpdate()" class="btn btn-neutral btn-link btn-sm top-margin pull-right">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <button style="display: none" id="refreshList" ng-click="updateListFunc()">{{updateList}}</button>
                <div class="contain">
                <div class="form-create-task margin-left-1">

                    <form name="saveTaskData" class="form-horizontal" ng-submit="submit()">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <input class="form-control" ng-model="data.inputTaskName" placeholder="Task Name" type="text" required>

                                <input ui-timepicker class="form-control-2" ng-model="data.inputTaskStart" placeholder="Task Start Time" id="selector_start_create" type="text" required>
                                <span class="contain_text_middle">
                                    <h4>until</h4>
                                </span>
                                <input ui-timepicker class="form-control-2 fc2-left" ng-model="data.inputTaskEnd" placeholder="Task End Time" id="selector_end_create" type="text" required>

                                <input style="display: none !important;" class="form-control" ng-model="data.sharedWith" type="text" id="datepicker">

                                <datepicker date-format="yyyy-MM-dd"><input id="datefocus" class="form-control" ng-model="data.inputTaskDate" placeholder="Task Date" type="text" readonly required></datepicker>
                                <br>

                                <select class="form-control" ng-model="selectedItem"
                                ng-options="type as type.value for type in data.types" required>
                                    <option value="" disabled selected>Choose Type</option>
                                    
                                </select>

                                <textarea class="form-control" ng-model="data.inputTaskInfo" placeholder="Task Information" type="text" required></textarea>
                                <br>
                                <div id="center">
                                    <button type="submit" class="btn btn-stretch-2 btn-success btn-sm">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>


            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#upcoming" role="tab">Today</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#all" role="tab">Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#group" role="tab">Shared</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#expired" role="tab">Expired</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content text-left">
                <div class="tab-pane active" id="upcoming" role="tabpanel">
                    <div id="displayUser" ng-controller="displayUserCtrl" ng-cloak>

                        <div ng-repeat="tasks in filteredTasks = (userTasks | filter: filterToday)">
                            <div class="tasks">
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
                            <h4 style="text-align: center">No tasks today</h4>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="expired" role="tabpanel">
                    <div ng-controller="displayUserCtrl" ng-cloak>

                        <div ng-repeat="tasks in filterExpired = (userTasks | filter: filterLess) | orderBy: tasks.task_date:true">
                            <div class="tasks">
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

                        <div class="no-tasks" ng-show="filterExpired.length == 0">
                            <h4 style="text-align: center">No expired tasks</h4>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="all" role="tabpanel">
                    <div ng-controller="displayAllCtrl" ng-cloak>

                        <div ng-repeat="tasks in filteredAll = (allTasks | filter: filterGreater)">
                            <div class="tasks">
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

                        <div ng-repeat="tasks in filteredGroup = (groupTasks | filter:filterGreater)">
                            <div class="tasks">
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
                            <h4 style="text-align: center">No active shared tasks</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div id="calendar" class="margined-top" ng-controller="calendarCtrl">

            <div class="information-contain">
                <div class="circle task-meeting"></div>
                <div class="inline">
                    <h5>Meeting</h5>
                </div>
                <div class="circle task-event"> </div>
                <div class="inline">
                    <h5>Event</h5>
                </div>
                <div class="circle task-personal"> </div>
                <div class="inline">
                    <h5>Personal</h5>
                </div>
                <div class="circle task-work"> </div>
                <div class="inline">
                    <h5>Work</h5>
                </div>
            </div>

        </div>



    </div>
</div>
</div>
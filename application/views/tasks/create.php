<div class="containTask" ng-app="task">



    <form name="saveTaskData" ng-controller="createCtrl" ng-submit="submit()">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> <input class="form-control" ng-model="data.inputTaskName" placeholder="Task Name" type="text"></h3>
            </div>
       
            <div class="panel-body">
                <p><input class="form-control" ng-model="data.inputTaskStart" placeholder="Task Start Date" type="text"></p>
                <p><input class="form-control" ng-model="data.inputTaskEnd" placeholder="Task End Date" type="text"></p>
                <p><input class="form-control" ng-model="data.inputTaskTime" placeholder="Task Time" type="text"></p>
                <p><input class="form-control" ng-model="data.inputTaskInfo" placeholder="Task Information" type="text"></p>
                
                    <div class="navbar-header">
                        <ul class="nav navbar-nav">
                            <li><button type="submit" class="btn btn-warning btn-sm">Create</button></li>
                        </ul>
                    </div>
            </div>
        </div>
        </form>
    </div>   


<div class="containTask" ng-app="task">


    <div ng-controller="taskCtrl">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> <input class="form-control" id="inputTaskName" value="<?= $task_name ?>" type="text"></h3>
            </div>
       
            <div class="panel-body">
                <p><input class="form-control" id="inputTaskStart" value="<?= $start_date ?>" type="text"></p>
                <p><input class="form-control" id="inputTaskEnd" value="<?= $start_date ?>" type="text"></p>
                <p><input class="form-control" id="inputTaskTime" value="<?= $task_time ?>" type="text"></p>
                <p><input class="form-control" id="inputTaskInfo" value="<?= $task_info ?>" type="text"></p>
                
                    <div class="navbar-header">
                        <ul class="nav navbar-nav">
                            <li><button class="btn btn-warning btn-sm" ng-click="update()">Update</button></li>
                        </ul>
                    </div>
            </div>
        </div>
    </div>   
</div>


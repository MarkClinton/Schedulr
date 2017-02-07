<div class="containTask" ng-app="task">


    <div ng-controller="taskCtrl">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Update Task</h3>
            </div>
       
            <div class="panel-body">
                <p><input class="form-control" id="inputTaskName" value="<?= $task_name ?>" type="text"></p>
                <p><input class="form-control" id="inputTaskStart" value="<?= $start_time ?>" type="text"></p>
                <p><input class="form-control" id="inputTaskEnd" value="<?= $end_time ?>" type="text"></p>
                <p><input class="form-control" id="inputTaskTime" value="<?= $task_date ?>" type="text"></p>
                <p><input class="form-control" id="inputTaskInfo" value="<?= $task_info ?>" type="text"></p>
                
                    
                <div id="right"><button class="btn btn-warning btn-sm" ng-click="update()">Update</button></div>
        
            </div>
        </div>
    </div>   
</div>


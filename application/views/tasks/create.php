<div class="containTask" ng-app="task">
    <h4>Create Task</h4>
    <br/>
    <form name="saveTaskData" class="form-horizontal" ng-controller="createCtrl" ng-submit="submit()"> 
        <div class="panel panel-primary">
            <div class="panel-body">
                <p><input class="form-control" ng-model="data.inputTaskName" placeholder="Task Name" type="text" required></p>
                <p><input ui-timepicker class="form-control" ng-model="data.inputTaskStart" placeholder="Task Start Time" id="selector" type="text" required></p>

                <p><input ui-timepicker class="form-control" ng-model="data.inputTaskEnd" placeholder="Task End Time" id="selector2" type="text" required></p>
                <!--<p><input class="form-control" ng-model="data.inputTaskDate" placeholder="Task Date" type="text" id="datepicker"></p>-->

                <p><datepicker date-format="yyyy-MM-dd"><input class="form-control" ng-model="data.inputTaskDate" placeholder="Task Date" type="text" required></datepicker></p>

                <p><textarea class="form-control" ng-model="data.inputTaskInfo" placeholder="Task Information" type="text" required></textarea></p>

                <button type="submit" class="btn btn-outline-success btn-sm">Create</button>
            </div>
        </div>
    </form>
</div>   


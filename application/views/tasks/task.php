<div class="container" ng-app="task">

    <div class='viewTask' ng-controller="taskCtrl">

        <div class="taskBoard">

        </div>


        <div class="taskSideContain">
            <div class="taskHeader">
                <h5>{{data.inputTaskName}}</h5>
                <p>{{data.inputTaskDate}}</p>
                <p>*Participants*</p>

            </div>

            <div class='taskSideBar'>
                <h5>Message Board</h5>


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


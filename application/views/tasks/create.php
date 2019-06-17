<div class="container">

    <div class="containTask" ng-app="task">
        <div class="form-create-task">
            <h5 style="text-align: left;">Create New</h5>
            
            <form name="saveTaskData" class="form-horizontal" ng-controller="createCtrl" ng-submit="submit()"> 
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <input class="form-control" ng-model="data.inputTaskName" placeholder="Task Name" type="text" required>

                        
                        <input ui-timepicker class="form-control-2" ng-model="data.inputTaskStart" placeholder="Task Start Time" id="selector_start_create" type="text" required>
                        <span class="contain_text_middle"> <h4>until</h4></span>
                        <input ui-timepicker class="form-control-2 fc2-left" ng-model="data.inputTaskEnd" placeholder="Task End Time" id="selector_end_create" type="text" required>
                        
                        <input style="display: none !important;" class="form-control" ng-model="data.sharedWith" type="text" id="datepicker">

                        <datepicker date-format="yyyy-MM-dd"><input class="form-control" ng-model="data.inputTaskDate" placeholder="Task Date" type="text" required></datepicker>
                        <br>

                        <select class="form-control" ng-model="selectedItem"
                                ng-options="type as type.value for type in data.types" required>
                                <option value="" disabled selected>Choose Type</option>
                                    
                        </select>
                        
                        <textarea class="form-control" ng-model="data.inputTaskInfo" placeholder="Task Information" type="text" required></textarea>
                        <br>
                        <div id="left">
                            <button type="submit" class="btn btn-stretch-2 btn-success btn-sm">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div ng-controller="getFriendsCtrl"
        <div class="share-create-task">
            
            <div class="create-share-friends">
                <h5 style="text-align: left;">Share With</h5>
                <div ng-repeat="friend in friends">
                    <div class="par_layout">
                        <img class="sml profile shre" ng-click="addToShare(friend)" src="<?php echo base_url() ?>{{friend.img_url}}" title="{{friend.first_name}}" alt="profile" />
                    </div>
                </div>
            </div>

            <div class="create-share-friends">
                <h5 style="text-align: left;">Shared</h5>
                <div ng-repeat="add in added">
                    <div class="par_layout">
                        <img class="sml profile shre" ng-click="removeFromShare(add)" src="<?php echo base_url() ?>{{add.img_url}}" title="{{add.first_name}}" alt="profile" />
                    </div>
                </div>

            </div>


        </div>
    </div>   
</div>


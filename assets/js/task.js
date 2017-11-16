var task = angular.module('task', ['720kb.datepicker', 'cgNotify']);

task.controller('taskCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {
        $scope.data = {};
        
        function getQueryVariable(variable)
        {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    return pair[1];
                }
            }
            return(false);
        }

        var id = getQueryVariable("id");
        var tasks = $http.get("viewTask?id=" + id);
            
        tasks.then(function (response) {
            var task = response.data;
            $scope.data.inputTaskName = task[0].TASK_NAME;
            $scope.data.inputTaskStart = task[0].START_TIME;
            $scope.data.inputTaskEnd = task[0].END_TIME;
            $scope.data.inputTaskDate = task[0].TASK_DATE;
            $scope.data.inputTaskInfo = task[0].TASK_INFO; 
            $scope.data.id = task[0].TASK_ID;
        });
        
        //var update = $http.get('updateTask');
        
        $('#selector').wickedpicker({
            twentyFour: true,
            now: "12:00",
            upArrow: 'wickedpicker__controls__control-up',
            downArrow: 'wickedpicker__controls__control-down',
            close: 'wickedpicker__close',
            hoverState: 'hover-state',
            title: 'Start Time'
        });

        $('#selector2').wickedpicker({
            twentyFour: true,
            now: "12:00",
            upArrow: 'wickedpicker__controls__control-up',
            downArrow: 'wickedpicker__controls__control-down',
            close: 'wickedpicker__close',
            hoverState: 'hover-state',
            title: 'End Time'
        });
        
        $scope.update = function () {

            $scope.data.inputTaskStart = $('#selector').val().replace(/\s/g, '');
            $scope.data.inputTaskEnd = $('#selector2').val().replace(/\s/g, '');
            $http(({
                method: 'POST',
                url: 'updateTask',
                data: $scope.data, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
                
                var status = response.data;
                if(status == 200){
                    notify({ message:'Task Updated successfully'} );
                    window.setTimeout(function(){window.location.href = "../users/index"},1000); 
                } else {
                    notify({ message:'Task Could Not Be Created. Please Try Again.'} );
                } 
            });

        };


    }]);

task.controller('createCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {

        $('#selector').wickedpicker({
            twentyFour: true,
            now: "12:00",
            upArrow: 'wickedpicker__controls__control-up',
            downArrow: 'wickedpicker__controls__control-down',
            close: 'wickedpicker__close',
            hoverState: 'hover-state',
            title: 'Start Time'
        });

        $('#selector2').wickedpicker({
            twentyFour: true,
            now: "12:00",
            upArrow: 'wickedpicker__controls__control-up',
            downArrow: 'wickedpicker__controls__control-down',
            close: 'wickedpicker__close',
            hoverState: 'hover-state',
            title: 'End Time'
        });

        $scope.data = {};
        $scope.data.inputTaskStart = "12:00";
        $scope.data.inputTaskEnd = "12:00";
        $scope.submit = function () {

            $scope.data.inputTaskStart = $('#selector').val().replace(/\s/g, '');
            $scope.data.inputTaskEnd = $('#selector2').val().replace(/\s/g, '');
            $http(({
                method: 'POST',
                url: 'createTask',
                data: $scope.data, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
                    
                var status = response.data;
                if(status == 200){
                    notify({ message:'Task Created successfully'} );
                    window.setTimeout(function(){window.location.href = "../users/index"},1000); 
                } else {
                    notify({ message:'Task Could Not Be Created. Please Try Again.'} );
                }   
            });

        };

    }]);

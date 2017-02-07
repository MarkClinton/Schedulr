var task = angular.module('task', ['720kb.datepicker']);

task.controller('taskCtrl', ['$scope', '$http', function ($scope, $http) {
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
                
                window.location.href = "../index";
            });

        };


    }]);

task.controller('createCtrl', ['$scope', '$http', function ($scope, $http) {

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
                window.location.href = "../index";
            });

        };

    }]);

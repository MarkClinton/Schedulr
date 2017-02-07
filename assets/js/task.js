var task = angular.module('task', ['720kb.datepicker']);

task.controller('taskCtrl', ['$scope', '$http', function ($scope, $http) {
        var tasks = $http.get('viewTask');

        tasks.then(function (response) {
            var request = response.data;
            $scope.tasks = request;
        });
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

var task = angular.module('task', ['720kb.datepicker', 'cgNotify']);

task.controller('taskCtrl', ['$scope', '$http', 'getTaskShareData', 'notify', function ($scope, $http, getTaskShareData, notify) {
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
        $scope.task_id = id;
        var tasks = $http.get("viewTask?id=" + id);
            
        tasks.then(function (response) {
            var task = response.data;

            $scope.data.admin = task[0][0];
            $scope.data.share = task[1];
        });

        $scope.isAdmin = function(data){
            return (data.ID != $scope.data.admin.ADMIN);
        };
        
        $scope.addUsers = function(data){
            console.log(data + $scope.task_id);
            var addU = $http.get('addUser?taskId=' + $scope.task_id + '&userId=' + data);

            addU.then(function (response) {
                getTaskShareData.getParticipants($scope.task_id).then(function(data){
                    $scope.data.share = data;
                    console.dir($scope.data.share);
                });
            })

        }

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

task.factory('getTaskShareData', ['$http', function($http) {
    return{
    getParticipants: function(id){
        return $http.get('viewTask?id=' + id).then(function(response) {
                var result = response.data;
                var share = result[1];
                console.dir(result);
                return share;
        }); 
    }
};
}]);

task.controller('getFriendsCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {

    $scope.friend = {};
    var friends = $http.get('showFriends');

    friends.then(function (response) {
        $scope.friend = response.data;
        console.dir($scope.friend);
    });
 
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

var task = angular.module('task', []);

task.controller('taskCtrl', ['$scope', '$http', function ($scope, $http) {
        var tasks = $http.get('viewTask');
        
        tasks.then(function (response) {
            var request = response.data;
            $scope.tasks = request;
        });
}]);

task.controller('createCtrl', ['$scope', '$http', function ($scope, $http) {
        
    $scope.data = {};
    $scope.submit = function() {
        $http(({
          method  : 'POST',
          url     : 'createTask',
          data    : $scope.data, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })).then(function(response){
                window.alert(response.data);
                window.location.href = "../index";
            });

    };
}]);


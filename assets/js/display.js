
var fetch = angular.module('fetch', ['cgNotify']);

fetch.controller('getProfileCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {

        var users = $http.get('getProfile');
        
        users.then(function (response) {
            var request = response.data; 
            //window.alert(request);
            $scope.profile = request;
        });
        
        
}]);

fetch.controller('updateProfileCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {
        
        $scope.data = {};
        var users = $http.get('getProfile');
        
        users.then(function (response) {
            var request = response.data; 
            $scope.data.first_name = request[0].FIRST_NAME;
            $scope.data.last_name = request[0].LAST_NAME;
            $scope.data.email = request[0].EMAIL;
            $scope.data.password = request[0].PASSWORD;
        });
        
        $scope.save = function () {
            $http(({
                method: 'POST',
                url: 'updateProfile',
                data: $scope.data, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
                
                var status = response.data;
                if(status == 200){
                    notify({ message:'Details Updated successfully'} );
                    window.setTimeout(function(){window.location.href = "profile"},1000); 
                } else {
                    notify({ message:'Details Could Not Be Created. Please Try Again.'} );
                } 
            });
        }
        
        
}]);

fetch.controller('srchPeopleCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {
       
        
        $scope.change = function () {
            $scope.entries = null;
            $http(({
                method: 'POST',
                url: 'searchPeople',
                data: $scope.src, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (result) {
                $scope.entries = null;
                $scope.entries = result.data;
            });
        };
    }]);

fetch.controller('displayUserCtrl', ['$scope', '$http', '$rootScope', 'notify', function ($scope, $http, notify) {
        var userTasks = $http.get('displayTasks');
        
        userTasks.then(function (response) {
            var request = response.data; 
            $scope.userTasks = request;
            $scope.date = new Date();
        });
        
        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID;
        };
        
        $scope.delete = function(data, index) {
            //$scope.userTasks.splice(index, 1);
            var indexOf = $scope.userTasks.indexOf(data.TASK_ID);
            var deleteTask = $http.get('tasks/delete?id=' + data.TASK_ID);
            
            deleteTask.then(function (response){
                var status = response.data;
                if(status == 200){
                    $scope.userTasks.splice(indexOf, 1);
                    //notify({ message:'Task Deleted successfully'} );
                } else {
                    //notify({ message:'Task Could Not Be Deleted. Please Try Again.'} );
                } 
            });
            
        };
        
        
}]);

fetch.controller('displayGroupCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify){
        var groupTasks = $http.get('displayGroupTasks');
        
        groupTasks.then(function (response) {
            var request = response.data; 
            $scope.groupTasks = request;
        });

        $scope.showGroupTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID; 
        }; 
        
        $scope.delete = function(data, index) {
            
            var deleteTask = $http.get('tasks/delete?id=' + data.TASK_ID);
            
            deleteTask.then(function (response){
                var status = response.data;
                if(status == 200){
                    $scope.groupTasks.splice(index, 1);
                    notify({ message:'Task Deleted successfully'} );
                    //window.setTimeout(function(){window.location.href = ""},1000); 
                } else {
                    notify({ message:'Task Could Not Be Deleted. Please Try Again.'} );
                }
            });
            
        };
}]);

fetch.controller('displayUpcomingCtrl', ['$scope', '$http', '$rootScope', function ($scope, $http){
        var upcomingTasks = $http.get('displayUpcomingTasks');
        
        upcomingTasks.then(function (response) {
            var request = response.data; 
            $scope.upcomingTasks = request;
        });
        
        $scope.showModal = false;
        $scope.buttonClicked = "";
        $scope.showUpcomingTask = function(data){
            $scope.task = data;
            $scope.showModal = !$scope.showModal;
   
        };
        
}]);

fetch.directive('modal', function () {
    return{
        template: '<div class="modal">' +
                    '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                            '<div class="modal-header">' +
                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                                '<h4 class="modal-title">{{task.TASK_NAME}}</h4>' +
                            '</div>' +
                            '<div class="modal-body">' +
                            '<p> {{task.TASK_DATE}} </p>' +
                            '<p> {{task.START_TIME}} - {{task.END_TIME}} </p>' +
                            '<p> {{task.TASK_INFO}}</p>' +
                            '</div>' +
                        '</div>'+
                    '</div>'+
                '</div>',
        restrict: 'E',
        transclude: true,
        replace: true,
        scope: true,
        link: function postLink(scope, element, attrs){
            scope.$watch(attrs.visible, function(value){
                if(value == true)
                    $(element).modal('show');
                else
                    $(element).modal('hide');
            });
            
            $(element).on('shown.bs.modal', function(){
                scope.$apply(function(){
                    scope.$parent[attrs.visible] = true;
                });
            });
            
            $(element).on('hidden.bs.modal', function(){
                scope.$apply(function(){
                    scope.$parent[attrs.visible] = false;
                });
            });  
        }
    };   
});










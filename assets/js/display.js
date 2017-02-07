
var fetch = angular.module('fetch', []);


fetch.controller('displayUserCtrl', ['$scope', '$http', function ($scope, $http) {
        var userTasks = $http.get('displayTasks');
        
        userTasks.then(function (response) {
            var request = response.data; 
            $scope.userTasks = request;
        });
        
        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID;
        };
        
        $scope.delete = function(data) {
            
            var deleteTask = $http.get('tasks/delete?id=' + data.TASK_ID);
            
            deleteTask.then(function (response){
                alert(response.data);
                window.location.href = "";
            });
            
        };
        
        
}]);

fetch.controller('displayGroupCtrl', ['$scope', '$http', function ($scope, $http){
        var groupTasks = $http.get('displayGroupTasks');
        
        groupTasks.then(function (response) {
            var request = response.data; 
            $scope.groupTasks = request;
        });

        $scope.showGroupTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID; 
        }; 
        
        $scope.delete = function(data) {
            
            var deleteTask = $http.get('tasks/delete?id=' + data.TASK_ID);
            
            deleteTask.then(function (response){
                alert(response.data);
                window.location.href = "";
            });
            
        };
}]);

fetch.controller('displayUpcomingCtrl', ['$scope', '$http', function ($scope, $http){
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
                            '<p> {{task.START_TIME}} </p>' +
                            '<p> {{task.TASK_DATE}} </p>' +
                            '<p> {{task.TASK_INFO}}</p>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                            '</div>'+
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










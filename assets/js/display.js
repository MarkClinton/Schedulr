var fetch = angular.module('fetch', ['cgNotify']);

fetch.controller('getProfileCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {

        var users = $http.get('getProfile');
        
        users.then(function (response) {
            var request = response.data; 
            //window.alert(JSON.stringify(request));
            $scope.img = request[0].URL;
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


fetch.controller('showFriendsCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {

    $scope.friends = {};
    var friends = $http.get('getFriends');

    friends.then(function (response) {
        $scope.friends = response.data;
    });
 
}]);


fetch.factory('remove', function($http) {

    var deleteData = {};

    return{
        deleteData: function(data){
            deleteData = data;
            return $http.get('tasks/delete?id=' + data.TASK_ID)
            .then(function (response){
                $('#calendar').fullCalendar( 'refetchEvents' );
                return response.data;
            });
        },

        returnDeleted: function(){
            return deleteData;
        },

        removeFromList: function(list){
            for(var i = 0; i < list.length; i++) {
                var obj = list[i];

                if(deleteData.TASK_ID.indexOf(obj.TASK_ID) !== -1) {
                    list.splice(i, 1);
                    i--;
                    return list;
                }
            }
        }
    };

});

// Factory to get tasks for all controllers
fetch.factory('getData', function($http){
    this.getTasks = function(pass){
            return $http.get(pass)
            .then(function(response) {
                return response.data;
            });
    }
    return this;
});


fetch.controller('displayUserCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', function ($scope, $http, $rootScope, notify, getData, remove) {

        var route = 'displayUpcomingTasks';
        getData.getTasks(route).then(function(data){
            $scope.userTasks = data;
        });

        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            $scope.userTasks = remove.removeFromList($scope.userTasks);   
        });
        
        
        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID;
        };
        
        $scope.delete = function(data) {
            remove.remove(data);
        }

        $scope.delete = function(data) {

            var removeData = remove.deleteData(data);
            var deleted = remove.returnDeleted();
            console.log(removeData);
            
        }; 
        
}]);

fetch.controller('displayGroupCtrl', ['$scope', '$http', 'notify', 'getData', 'remove', function ($scope, $http, notify, getData, remove){
        
        var route = 'displayGroupTasks';
        getData.getTasks(route).then(function(data){
            $scope.groupTasks = data;
        });

        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            $scope.groupTasks = remove.removeFromList($scope.groupTasks);
        });

        $scope.showGroupTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID; 
        }; 
        
        $scope.delete = function(data, index) {
            
           var removeData = remove.deleteData(data);
            var deleted = remove.returnDeleted();
            console.log(removeData);
            
        };
}]);

fetch.controller('displayAllCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', function ($scope, $http, $rootScope, notify, getData, remove) {
        
        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            $scope.allTasks = remove.removeFromList($scope.allTasks);
        });

        var route = 'displayTasks';
        getData.getTasks(route).then(function(data){
            $scope.allTasks = data;
        });
        
        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID;
        };
        
        $scope.delete = function(data) {
            var removeData = remove.deleteData(data);
            var deleted = remove.returnDeleted();
            console.log(removeData);
            
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
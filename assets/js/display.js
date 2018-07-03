
/*
 * There should only be one controller for this class with different scopes depending on data
 * e.g. scope for upcoming, scope for all etc. 
 *
 * Make it easier to control all data being passed to the view
 */


var fetch = angular.module('fetch', ['cgNotify', 'fileService']);

fetch.controller('profileCtrl', ['$scope', '$http', 'notify', 'getProfileImagePath', 'uploadFileData', function ($scope, $http, notify, getProfileImagePath, uploadFileData) {

        var users = $http.get('getProfile');
        users.then(function (response) {
            var request = response.data.profile; 
            var request_details = response.data.profile_details;
            

            $scope.img = request[0].img_url;
            $scope.profile = request[0];
            $scope.details = request_details[0];
        });

        $scope.uploadImage = function () {
            var file = $scope.imageFile;
            var uploadUrl = 'imageUpload';
            var name = $scope.imageFile.name;

            uploadFileData.fileToUrl(file, uploadUrl, name);
            
            getProfileImagePath.imageUrl().then(function(data){
                $scope.img = data;
                pictureUpload();
            });
        }    
}]);

fetch.controller('updateProfileCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {
        
        $scope.data = {};
        var users = $http.get('getProfile');
        users.then(function (response) {
            var request = response.data.profile; 
            $scope.data.first_name = request[0].first_name;
            $scope.data.last_name = request[0].last_name;
            $scope.data.email = request[0].email;
            $scope.data.password = request[0].password;
        });

        $scope.timeline = {};
        var timeline = $http.get('getTimeline');
        timeline.then(function (response) {
            var request = response.data; 
            $scope.timeline = request;
            console.dir($scope.timeline);
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

        $scope.updatePword = function() {
            $http(({
                method: 'POST',
                url: 'updatePassword',
                data: $scope.update, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
                
                var status = response.data;
                if(status.code == 200){
                    notify({ message:status.response} );
                    window.setTimeout(function(){window.location.href = "profile"},1000); 
                } else {
                    notify({ message:status.response} );
                } 
            });
        }
        
        
}]);

fetch.factory('getProfileImagePath', ['$http', function($http) {
    return{
    imageUrl: function(){
        //profileImage
        return $http.get('profileImage').then(function(response) {
                var result = response.data;
                var img_pth = result[0].img_url;
                return img_pth;
        }); 
    }
};
}]);



fetch.controller('srchPeopleCtrl', ['$scope', '$http', 'getUsersFriends', 'notify', function ($scope, $http, getUsersFriends, notify) {
       
        
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

        $scope.isUser = function(data){
            return (data.id != $scope.data.admin.ADMIN);
        };

        $scope.remove = function(){
            $scope.entries = null;
        }

        /*$scope.friendStatus = function(data){
            console.dir(data);
            if(data == 1){
                return 'fa fa-check';
            }
            else if(data == 2){
                return 'fa fa-hourglass-half';
            }
            else if(data == 4){
                return 'fa fa-plus';
            }
        }*/

        $scope.addFriend = function (data) {
            var addFriends = $http.get('addFriends?userId=' + data);
            addFriends.then(function (response) {
                console.dir(response);
                getUsersFriends.getFriends().then(function(data){
                    $scope.change();
                });
        });

        }
    }]);


fetch.controller('showFriendsCtrl', ['$scope', '$http', 'getUsersFriends', 'notify', function ($scope, $http, getUsersFriends, notify) {

    $scope.friends = {};

    getUsersFriends.getFriends().then(function(data){
        $scope.friends = data;
    });

    $scope.$watch(function(){
        return getUsersFriends.returnFriends();
    }, function(newValue, oldValue){
        $scope.friends = getUsersFriends.returnFriends();
    });


    $scope.removeFriend = function(data) {
        if (confirm("Are you sure?")) {
            var deleteFriend = $http.get('deleteFriend?userId=' + data);
            deleteFriend.then(function (response) {
                getUsersFriends.getFriends().then(function(data){
                    $scope.friends = data;
                });       
            })
        } 
    }
 
}]);

fetch.factory('getUsersFriends', ['$http', function($http) {

    var friends = {};

    return{
        getFriends: function(){
            return $http.get('getFriends').then(function(response) {
                var result = response.data;
                friends = result;
                return result;
            }); 
        },

        returnFriends: function(){
            return friends;
        }
    };
}]);


fetch.factory('remove', function($http) {

    var deleteData = {};

    return{
         deleteData: function(data){
            deleteData = data;
            return $http.get('tasks/deleteTask?id=' + data.id)
            .then(function (response){
                $('#calendar').fullCalendar( 'refetchEvents' );
                return response.data;
            });
        },

        returnDeleted: function(){
            return deleteData;
        },

        removeFromList: function(list, route){
            if(list != undefined){
                for(var i = 0; i < list.length; i++) {
                    var obj = list[i];
                    
                    var toDelete = deleteData.id;

                    if(obj.id == toDelete) {
                        list.splice(i, 1);
                        i--;
                        return list;
                    }
                } 
            }
            return null;  
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

fetch.factory('color', function () {
    
    var color = '';

    return {
        getColor: function(type) {
            if(type == 1){
                color = 'task-meeting';
            }else if(type == 2){
                color = 'task-event';
            }else if(type == 3){
                color = 'task-personal';
            }else{
                color = 'task-work';
            }
            return color;
        }
    };

});

fetch.factory('date', function () {

    return{
        todaysDate: function(){
            var today = new Date();

            var dd = today.getDate();
            var mm = today.getMonth()+1; 
            var yyyy = today.getFullYear();

            if(dd<10){
                dd='0'+dd;
            } 

            if(mm<10){
                mm='0'+mm;
            }

            var date = yyyy + '-' + mm + '-' + dd;
            return date;
        },

        dateGreater: function(task, date){
            if(task.task_date >= date){
                return true;
            }else{
                return false;
            }
        },

        dateLess: function(task, date){
            if(task.task_date < date){
                return true;
            }else{
                return false;
            }
        }
    };


});

fetch.controller('displayUserCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', 'color', 'date', function ($scope, $http, $rootScope, notify, getData, remove, color, date) {

        $scope.today = date.todaysDate();

        $scope.filterByDate = function(task){
            return date.dateGreater(task, $scope.today);
        }

        $scope.filterByExpired = function(task){
            return date.dateLess(task, $scope.today);
        }

        $scope.userTasks = {};
        $scope.created_by = '';

        var route = 'displayUpcomingTasks';
        getData.getTasks(route).then(function(data){
            console.dir(data);
            $scope.userTasks = data.tasks;
            $scope.created_by = data.user_id;
        });

        $scope.taskColor = function(type){
            var css = color.getColor(type);
            return css;
        };

        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            var newList = remove.removeFromList($scope.userTasks, route);   
            if (newList != null){
                $scope.userTasks = newList
            }
        });

        
        $scope.isAdmin = function(data){
            return (data == $scope.created_by);
        };
        
        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.id;
        };
        
        

        $scope.delete = function(data) {
            var removeData = remove.deleteData(data);
        }; 
    
        
}]);

fetch.controller('displayGroupCtrl', ['$scope', '$http', 'notify', 'getData', 'remove', 'color', 'date', function ($scope, $http, notify, getData, remove, color, date){
            
        $scope.today = date.todaysDate();

        $scope.filterByDate = function(task){
            return date.dateGreater(task, $scope.today);
        }

        var route = 'displayGroupTasks';
        getData.getTasks(route).then(function(data){
            $scope.groupTasks = data.tasks;

        });

        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            var newList = remove.removeFromList($scope.groupTasks, route);   
            if (newList != null){
                $scope.userTasks = newList
            }
        });

        $scope.taskColor = function(type){
            var css = color.getColor(type);
            return css;
        };

        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.id; 
        }; 
        
        $scope.delete = function(data, index) {
            //var deleted = remove.returnDeleted();
            var removeData = remove.deleteData(data);
            
            //console.log(removeData);
            
        };
}]);

fetch.controller('displayAllCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', 'color', 'date', function ($scope, $http, $rootScope, notify, getData, remove, color, date) {
        
        $scope.today = date.todaysDate();

        $scope.filterByDate = function(task){
            return date.dateGreater(task, $scope.today);
        }

        $scope.allTasks = {};
        $scope.created_by = '';

        var route = 'displayTasks';
        getData.getTasks(route).then(function(data){
            $scope.allTasks = data.tasks;
            $scope.created_by = data.user_id;
        });

        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            var newList = remove.removeFromList($scope.allTasks, route);   
            if (newList != null){
                $scope.userTasks = newList
            }
        });

        $scope.taskColor = function(type){
            var css = color.getColor(type);
            return css;
        };

        $scope.isAdmin = function(data){
            return (data == $scope.created_by);
        };

        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.id;
        };
        
        $scope.delete = function(data) {
            //var deleted = remove.returnDeleted();
            var removeData = remove.deleteData(data);
            
            //console.log(removeData);
            
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
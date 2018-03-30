var fetch = angular.module('fetch', ['cgNotify']);

fetch.controller('profileCtrl', ['$scope', '$http', 'notify', 'getProfileImagePath', 'uploadFileData', function ($scope, $http, notify, getProfileImagePath, uploadFileData) {

        var users = $http.get('getProfile');
        users.then(function (response) {
            var request = response.data; 
            

            $scope.img = request[0].URL;
            $scope.profile = request;
        });

        $scope.uploadImage = function () {
            var file = $scope.imageFile;
            console.dir(file);
            var uploadUrl = 'imageUpload';
            var name = $scope.imageFile.name;

            uploadFileData.fileToUrl(file, uploadUrl, name);
            var pp = getProfileImagePath.imageUrl();
            
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

fetch.factory('getProfileImagePath', ['$http', function($http) {
    return{
    imageUrl: function(){
        //profileImage
        return $http.get('getProfile').then(function(response) {
                var result = response.data;
                var img_pth = result[0].URL;
                return img_pth;
        }); 
    }
};
}]);

//ng-model does not provide 2 way binding for file fields. This directive provides the missing binding 
//needed to access file contents.
fetch.directive('fileModel', function ($parse) {
        return {
            restrict: 'A', //the directive can be used as an attribute only
 
            /*
             link is a function that defines functionality of directive
             scope: scope associated with the element
             element: element on which this directive used
             attrs: key value pair of element attributes
             */
            link: function (scope, element, attrs) {
                var model = $parse(attrs.fileModel),
                    modelSetter = model.assign; //define a setter for demoFileModel
 
                //Bind change event on the element
                element.bind('change', function () {
                    //Call apply on scope, it checks for value changes and reflect them on UI
                    scope.$apply(function () {
                        //set the model value
                        modelSetter(scope, element[0].files[0]);
                    });
                });
            }
        };
    });

// Reusable file upload service
fetch.service('uploadFileData', ['$http', function($http) {

    this.fileToUrl = function(file, url, fileName){

        var fd = new FormData();
        fd.append('file', file);
        fd.append('name', fileName);

        $http(({
            method: 'POST',
            url: url,
                data: fd, //forms user object
                headers: {'Content-Type': undefined,'Process-Data': false}
            })).then(function (result) {
            //location.reload();
            console.dir(result);
            console.log('Image upload');
        });
        }
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
            return (data.ID != $scope.data.admin.ADMIN);
        };

        $scope.addFriend = function (data) {
            var addFriends = $http.get('addFriends?userId=' + data);
            addFriends.then(function (response) {
                console.dir(response);
                getUsersFriends.getFriends().then(function(data){
                    console.dir(data);
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
            return $http.get('tasks/delete?id=' + data.TASK_ID)
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
                    
                    var toDelete = deleteData.TASK_ID;

                    if(obj.TASK_ID == toDelete) {
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


fetch.controller('displayUserCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', function ($scope, $http, $rootScope, notify, getData, remove) {

        var route = 'displayUpcomingTasks';
        getData.getTasks(route).then(function(data){
            $scope.userTasks = data;
        });

        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            var newList = remove.removeFromList($scope.userTasks, route);   
            if (newList != null){
                $scope.userTasks = newList
            }
        });
        
        
        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID;
        };
        
        /*$scope.delete = function(data) {
            remove.remove(data);
        }*/

        $scope.delete = function(data) {
            //var deleted = remove.returnDeleted();
            var removeData = remove.deleteData(data);
            
            //console.log(removeData);
            
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
            var newList = remove.removeFromList($scope.groupTasks, route);   
            if (newList != null){
                $scope.userTasks = newList
            }
        });

        $scope.showGroupTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID; 
        }; 
        
        $scope.delete = function(data, index) {
            //var deleted = remove.returnDeleted();
            var removeData = remove.deleteData(data);
            
            //console.log(removeData);
            
        };
}]);

fetch.controller('displayAllCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', function ($scope, $http, $rootScope, notify, getData, remove) {
        
        var route = 'displayTasks';
        getData.getTasks(route).then(function(data){
            $scope.allTasks = data;
        });

        $scope.$watch(function () {
            return remove.returnDeleted();
        }, function (val) {
            var newList = remove.removeFromList($scope.allTasks, route);   
            if (newList != null){
                $scope.userTasks = newList
            }
        });

        $scope.showTask = function(data){
            window.location.href = "tasks/task?id=" + data.TASK_ID;
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
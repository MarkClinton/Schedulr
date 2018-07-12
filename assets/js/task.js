var task = angular.module('task', ['720kb.datepicker', 'cgNotify', 'ngMap', 'fileService']);

task.controller('taskCtrl', ['$scope', '$http', 'getTaskShareData', 'notify', 'getUserFriends', 'sharedWith', 'getTaskMedia', 'NgMap', 'uploadFileData', 
    function ($scope, $http, getTaskShareData, notify, getUserFriends, sharedWith, getTaskMedia, NgMap, uploadFileData) {
        $scope.googlemap = 'https://maps.google.com/maps/api/js?key=AIzaSyAKGQaIHaiRawx9GHR2CgzsGptwWdiNv2w';
        $scope.map = [
            {
                coords: {lat: 40.7831, lng: -73.9712 }
            },
            {
                coords: {lat: 40.6782, lng: -73.9442 }
            }
        ];

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
            if(response.data == 400){
                
                window.setTimeout(function(){window.location.href = "../index"},1); 
            }else{
            var task = response.data.task;
            $scope.data.admin = task[0][0];
            $scope.data.share = task[1];
            $scope.data.logged = response.data.admin;

            getUserFriends.getFriends().then(function(data){
                $scope.data.friends = sharedWith.filterShareWithOnTask(data, $scope.data.share);
            });

            getTaskMedia.getMedia($scope.task_id).then(function(data){
                $scope.data.media = data;
            });
            }
        });

        $scope.isImage = function(file_name){
            var ext = ["jpg", "jpeg", "png", "gif"];

            for(i = 0; i < ext.length; i ++){
                if(file_name.includes(ext[i])){
                    return true;
                }
            }

            return false;
        };

        $scope.isAdmin = function(){
            // Errors are called because the 
            // isAdmin function is running before 
            // scope populates
            return($scope.data.logged == $scope.data.admin.ADMIN);
        };

        $scope.createdBy = function(user_id){
            // Errors are called because the 
            // isAdmin function is running before 
            // scope populates

            return($scope.data.logged == user_id);
        };

        $scope.taskColor = function(type){
            if(type == 1){
                return 'task-meeting';
            }else if(type == 2){
                return 'task-event';
            }else if(type == 3){
                return 'task-personal';
            }else{
                return 'task-work';
            }
        }
        
        $scope.addUsers = function(data){
            var user_id = data;

            var addU = $http.get('addUser?taskId=' + $scope.task_id + '&userId=' + user_id);

            addU.then(function (response) {
                getTaskShareData.getParticipants($scope.task_id).then(function(data){
                    $scope.data.friends = sharedWith.addAndRemoveFriendProject($scope.data.friends, user_id);
                    $scope.data.share = data;
                    
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

        $scope.deleteMedia = function(data){
            if (confirm("Are you sure?")) {
                console.dir(data);
                var deleteMedia = $http.get('deleteMedia?media_id=' + data);
                deleteMedia.then(function (response) {
                    getTaskMedia.getMedia($scope.task_id).then(function(data){
                        $scope.data.media = data;
                    });       
                })
            } 
        }

        $scope.addNote = function(){

            var note = [{
                "task_id": $scope.task_id,
                "admin": $scope.data.logged,
                "info": $scope.note.info
            }];

            $http(({
                method: 'POST',
                url: 'addFileToProject',
                data: JSON.stringify(note), //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
                closeNote();
                getTaskMedia.getMedia($scope.task_id).then(function(data){
                    $scope.data.media = data;
                }); 
            });
        }

        $scope.addLocation = function(){
            // coords from map.js file
            var coords = getCoords();

            var lat = coords['lat'];
            var lng = coords['lng'];
            var name = coords['name'];
            var location = [{
                "task_id": $scope.task_id,
                "admin": $scope.data.logged,
                "lat": lat,
                "lng": lng,
                "name": name
            }];


            $http(({
                method: 'POST',
                url: 'addLocationToProject',
                data: JSON.stringify(location), //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
                    closeLocation();
                    getTaskMedia.getMedia($scope.task_id).then(function(data){
                        $scope.data.media = data;
                    });

            });

        }

        $scope.addFile = function (){
            var file = $scope.imageFile;
            var uploadUrl = 'fileUpload';
            var name = $scope.imageFile.name;

            var file = [{
                'file': $scope.imageFile,
                "task_id": $scope.task_id,
                "admin": $scope.data.logged,
            }];

            uploadFileData.fileToUrl(file, uploadUrl, name).then(function(result) { 
                closeFile();
                getTaskMedia.getMedia($scope.task_id).then(function(data){
                    $scope.data.media = data;
                });
            });
        }

    }]);


task.factory('getTaskShareData', ['$http', function($http) {
    return{
        getParticipants: function(id){
            return $http.get('viewTask?id=' + id).then(function(response) {
                    var result = response.data.task;
                    var share = result[1];
                    return share;
            }); 
        }
    };
}]);


task.factory('getTaskMedia', ['$http', function($http){

    return{
        getMedia: function(task_id){
            return $http.get('getTaskMedia?task_id=' + task_id).then(function(response){
                var result = response.data;
                return result;
            });
        }
    };

}]);



/*
 * sharedWith factory holds the values of the selected users to be shared with.
 * Then gets called when the form submits. Passing an array of users.
 * Well at least it did before.
*/
task.factory('sharedWith', function () {

    var data = {
        shared: []
    };

    return {
        getShared: function() {
            return data.shared;
        },
        add: function(user) {
            data.shared.push(user);
        },
        remove: function(user) {
            for(var i = 0; i < data.shared.length; i++){

                var shared = data.shared[i];
                var shareToDelete = user.id;

                if(shared.id == shareToDelete){
                    data.shared.splice(i, 1);
                }
            }
            
        },
        addAndRemoveFriendProject: function(list, user){

            for(var i = 0; i < list.length; i++){

                var friend = list[i];
                //var objToRemove = user.id;

                if(friend.id == user){
                    list.splice(i, 1);
                }
            }

            return list;
        },
        filterShareWithOnTask: function(friends, shared) {

            if(shared != undefined && shared.length > 0){
                for(var i = 0; i < shared.length; i++){
                    for(var j = 0; j < friends.length; j++){
                        if(shared[i].id === friends[j].id){
                            friends.splice(friends[j], 1);
                        } 
                    }
                }
            }else{
                return friends;
            }
            return friends;
        }
            
    };
});

task.factory('getUserFriends', ['$http', function($http){
    return{
        getFriends: function(){
            return $http.get('../Users/getFriends').then(function(response){
                var result = response.data;
                return result;
            })
        }
    };
}]);



task.controller('getFriendsCtrl', ['$scope', '$http', 'notify', 'sharedWith', 'getUserFriends', 
    function ($scope, $http, notify, sharedWith, getUserFriends) {

    $scope.friends = [];
    $scope.added = [];

    getUserFriends.getFriends().then(function(data){
        $scope.friends = data;
    });

    

    /*
     * Used to add users to a task on task page
     */

    $scope.addToShare = function(user) {
        
        $scope.friends = sharedWith.addAndRemoveFriendProject($scope.friends, user.id);
        sharedWith.add(user);
        $scope.added.push(user);
    }

    $scope.removeFromShare = function(user) {

        $scope.added = sharedWith.addAndRemoveFriendProject($scope.added, user.id);
        sharedWith.remove(user);
        $scope.friends.push(user);
    }


 
}]);

task.controller('createCtrl', ['$scope', '$http', 'notify', 'sharedWith', function ($scope, $http, notify, sharedWith) {

        $('#selector').wickedpicker({
            twentyFour: true,
            now: "12 : 00",
            upArrow: 'wickedpicker__controls__control-up',
            downArrow: 'wickedpicker__controls__control-down',
            close: 'wickedpicker__close',
            hoverState: 'hover-state',
            title: 'Start Time',
            show : showPicker
        });

        $('#selector2').wickedpicker({
            twentyFour: true,
            now: "12 : 00",
            upArrow: 'wickedpicker__controls__control-up',
            downArrow: 'wickedpicker__controls__control-down',
            close: 'wickedpicker__close',
            hoverState: 'hover-state',
            title: 'End Time',
            show : showPicker
        });

        function showPicker( element ) {
            $( '.wickedpicker__title' ).contents().first().replaceWith( ( ( this.options !== undefined ) ? this.options.title : this.title ) );
        }

        $('#selector,#selector2').focus(function(){
            $('.wickedpicker').css({'display': 'none'});
        });

        


        $scope.data = {};
        $scope.data.inputTaskStart = "12:00";
        $scope.data.inputTaskEnd = "12:00";
        $scope.data.sharedWith = {};
        $scope.data.types = [
            {'id': 1, 'value': 'Meeting'},
            {'id': 2, 'value': 'Event'},
            {'id': 3, 'value': 'Personal'},
            {'id': 4, 'value': 'Work'}
        ];

        $scope.selectedItem = null;

        $scope.submit = function () {
            console.log($scope.selectedItem.id);

            $scope.data.inputTaskStart = $('#selector').val().replace(/\s/g, '');
            $scope.data.inputTaskEnd = $('#selector2').val().replace(/\s/g, '');
            $scope.data.sharedWith = sharedWith.getShared();
            $scope.data.types = $scope.selectedItem.id;

            $http(({
                method: 'POST',
                url: 'createTask',
                data: $scope.data, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
                    
                var status = response.status;
                if(status == 200){
                    notify({ message:'Task Created successfully'} );
                    window.setTimeout(function(){window.location.href = "../users/index"},1000); 
                } else {
                    notify({ message:'Task Could Not Be Created. Please Try Again.', classes: 'alert-danger'} );
                }   
            });

        };

    }]);

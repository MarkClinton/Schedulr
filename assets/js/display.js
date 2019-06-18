
/*
 * There should only be one controller for this class with different scopes depending on data
 * e.g. scope for upcoming, scope for all etc. 
 *
 * Make it easier to control all data being passed to the view
 */


var fetch = angular.module('fetch', ['cgNotify', 'fileService', 'cp.ngConfirm']);

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

        getProfileImagePath.imageUrl().then(function (data) {
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
    });


    $scope.save = function () {
        $http(({
            method: 'POST',
            url: 'updateProfile',
            data: $scope.data, //forms user object
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })).then(function (response) {

            var status = response.data;
            if (status == 200) {
                notify({ message: 'Details Updated successfully' });
                window.setTimeout(function () { window.location.href = "profile" }, 1000);
            } else {
                notify({ message: 'Details Could Not Be Created. Please Try Again.' });
            }
        });
    }

    $scope.updatePword = function () {
        $http(({
            method: 'POST',
            url: 'updatePassword',
            data: $scope.update, //forms user object
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })).then(function (response) {

            var status = response.data;
            if (status.code == 200) {
                notify({ message: status.response });
                window.setTimeout(function () { window.location.href = "profile" }, 1000);
            } else {
                notify({ message: status.response });
            }
        });
    }


}]);

fetch.factory('getProfileImagePath', ['$http', function ($http) {
    return {
        imageUrl: function () {
            //profileImage
            return $http.get('profileImage').then(function (response) {
                var result = response.data;
                var img_pth = result[0].img_url;
                return img_pth;
            });
        }
    };
}]);



fetch.controller('srchPeopleCtrl', ['$scope', '$http', 'getUsersFriends', 'notify', function ($scope, $http, getUsersFriends, notify) {

    $scope.change = function () {
        $scope.entries = [];
        var entry_results = [];
        $http(({
            method: 'POST',
            url: 'searchPeople',
            data: $scope.src, //forms user object
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })).then(function (result) {
            $scope.entries = result.data;
        });
    };

    $scope.isUser = function (data) {
        return (data.id != $scope.data.admin.ADMIN);
    };

    $scope.remove = function () {
        $scope.entries = null;
    }

    $scope.addFriend = function (data) {
        var addFriends = $http.get('addFriends?userId=' + data);
        addFriends.then(function (response) {
            console.dir(response);
            getUsersFriends.getFriends().then(function (data) {
                $scope.change();
            });
        });

    }
}]);


fetch.controller('showFriendsCtrl', ['$scope', '$ngConfirm', '$http', 'getUsersFriends', 'notify', function ($scope, $ngConfirm, $http, getUsersFriends, notify) {

    $scope.friends = {};

    getUsersFriends.getFriends().then(function (data) {
        $scope.friends = data;
    });

    $scope.$watch(function () {
        return getUsersFriends.returnFriends();
    }, function (newValue, oldValue) {
        $scope.friends = getUsersFriends.returnFriends();
    });


    $scope.removeFriend = function (id, f_name, l_name) {

        $ngConfirm({
            title: 'Confirm?',
            content: ' Are you sure you want to remove <strong>' + f_name + ' ' + l_name + '</strong> as your friend?',
            buttons: {
                sayBoo: {
                    text: 'Remove',
                    btnClass: 'btn-red',
                    action: function (button) {
                        var deleteFriend = $http.get('deleteFriend?userId=' + id);
                        deleteFriend.then(function (response) {
                            getUsersFriends.getFriends().then(function (data) {
                                $scope.friends = data;
                            });
                        })
                        return true; // prevent close;
                    }
                },
                close: function (button) {
                    // closes the modal
                },
            }
        });
    }

}]);

fetch.factory('getUsersFriends', ['$http', function ($http) {

    var friends = {};

    return {
        getFriends: function () {
            return $http.get('getFriends').then(function (response) {
                var result = response.data;
                friends = result;
                return result;
            });
        },

        returnFriends: function () {
            return friends;
        }
    };
}]);


fetch.factory('remove', function ($http, $ngConfirm) {

    var deleteData = {};
    var calChange = '';

    return {
        deleteData: function (data) {
            $ngConfirm({
                title: 'Confirm?',
                content: ' Are you sure you want to delete this task?',
                buttons: {
                    sayBoo: {
                        text: 'Remove',
                        btnClass: 'btn-red',
                        action: function (button) {
                            deleteData = data;
                            return $http.get('tasks/deleteTask?id=' + data.id)
                                .then(function (response) {
                                    $('#calendar').fullCalendar('refetchEvents');
                                    return response.data;
                                });
                            return true; // close;
                        }
                    },
                    close: function (button) {
                        // closes the modal
                    },
                }
            });
        },

        setListCheck: function (data) {
            calChange = data;
        },

        getNewList: function () {
            return calChange;

        },

        returnDeleted: function () {
            return deleteData;
        },

        removeFromList: function (list, route) {
            if (list != undefined) {
                for (var i = 0; i < list.length; i++) {
                    var obj = list[i];

                    var toDelete = deleteData.id;

                    if (obj.id == toDelete) {
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
fetch.factory('getData', function ($http) {
    this.getTasks = function (pass) {
        return $http.get(pass)
            .then(function (response) {
                return response.data;
            });
    }
    return this;
});

fetch.factory('color', function () {

    var color = '';

    return {
        getColor: function (type) {
            if (type == 1) {
                color = 'task-meeting';
            } else if (type == 2) {
                color = 'task-event';
            } else if (type == 3) {
                color = 'task-personal';
            } else {
                color = 'task-work';
            }
            return color;
        }
    };

});

fetch.factory('date', function () {

    return {
        todaysDate: function () {
            var today = new Date();

            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            var date = yyyy + '-' + mm + '-' + dd;
            return date;
        },

        activeTasks: function (task, date) {
            if (task.task_date >= date) {
                return task;
            }
        },

        dateGreater: function (task, date) {
            if (task.task_date > date) {
                return task;
            }
        },

        dateLess: function (task, date) {
            if (task.task_date < date) {
                return task;
            }
        },

        dateEquals: function (task, date) {
            if (task.task_date === date) {
                return task;
            }
        }
    };


});

fetch.controller('displayUserCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', 'color', 'date', function ($scope, $http, $rootScope, notify, getData, remove, color, date) {

    $scope.today = date.todaysDate();

    $scope.filterToday = function (data) {
        return date.dateEquals(data, $scope.today);
    };

    $scope.filterLess = function (data) {
        return date.dateLess(data, $scope.today);
    };

    $scope.filterActive = function (data) {
        return date.activeTasks(data, $scope.today);
    }

    $scope.userTasks = [];
    $scope.created_by = '';

    var route = 'displayUpcomingTasks';
    getData.getTasks(route).then(function (data) {
        $scope.userTasks = data.tasks;
        $scope.created_by = data.user_id;
    });

    $scope.taskColor = function (type) {
        var css = color.getColor(type);
        return css;
    };

    $scope.$watch(function () {
        return remove.returnDeleted();
    }, function (val) {
        var newList = remove.removeFromList($scope.userTasks, route);
        if (newList != null) {
            $scope.userTasks = newList;
        }
    });

    $scope.$watch(function () {
        return remove.getNewList();
    }, function () {
        getData.getTasks(route).then(function (data) {
            $scope.userTasks = data.tasks;
        });
    });

    $scope.isAdmin = function (data) {
        return (data == $scope.created_by);
    };

    $scope.showTask = function (data) {
        window.location.href = "tasks/task?id=" + data.id;
    };

    $scope.delete = function (data) {
        sremove.deleteData(data);
    };


}]);

fetch.controller('displayGroupCtrl', ['$scope', '$http', 'notify', 'getData', 'remove', 'color', 'date', function ($scope, $http, notify, getData, remove, color, date) {

    $scope.today = date.todaysDate();

    $scope.filterGreater = function (data){
        return date.dateGreater(data, $scope.today);
    };

    $scope.groupTasks = [];
    var route = 'displayGroupTasks';
    getData.getTasks(route).then(function (data) {
        $scope.groupTasks = data.tasks;

    });

    $scope.$watch(function () {
        return remove.returnDeleted();
    }, function (val) {
        var newList = remove.removeFromList($scope.groupTasks, route);
        if (newList != null) {
            $scope.groupTasks = newList
        }
    });

    $scope.$watch(function () {
        return remove.getNewList();
    }, function () {
        getData.getTasks(route).then(function (data) {
            $scope.groupTasks = data.tasks;
        });
    });

    $scope.taskColor = function (type) {
        var css = color.getColor(type);
        return css;
    };

    $scope.showTask = function (data) {
        window.location.href = "tasks/task?id=" + data.id;
    };

    $scope.delete = function (data, index) {
        remove.deleteData(data);
    };
}]);

fetch.controller('displayAllCtrl', ['$scope', '$http', '$rootScope', 'notify', 'getData', 'remove', 'color', 'date', function ($scope, $http, $rootScope, notify, getData, remove, color, date) {

    $scope.today = date.todaysDate();

    $scope.filterGreater = function (data){
        return date.dateGreater(data, $scope.today);
    };

    $scope.allTasks = [];
    $scope.created_by = '';

    var route = 'displayTasks';
    getData.getTasks(route).then(function (data) {
        $scope.allTasks = data.tasks;
        $scope.created_by = data.user_id;
    });

    $scope.$watch(function () {
        return remove.returnDeleted();
    }, function (val) {
        var newList = remove.removeFromList($scope.allTasks, route);
        if (newList != null) {
            $scope.allTasks = newList
        }
    });

    $scope.$watch(function () {
        return remove.getNewList();
    }, function () {
        getData.getTasks(route).then(function (data) {
            $scope.allTasks = data.tasks;
        });
    });

    $scope.taskColor = function (type) {
        var css = color.getColor(type);
        return css;
    };

    $scope.isAdmin = function (data) {
        return (data == $scope.created_by);
    };

    $scope.showTask = function (data) {
        window.location.href = "tasks/task?id=" + data.id;
    };

    $scope.delete = function (data) {
        remove.deleteData(data);
    };


}]);

/*
calendarCtrl uses $scope.$apply. It shouldnt be used. My understanding as to why its used here is that FullCalendar is outside the Angular framework.
FullCalendar is not properly integrated into AngularJs. E.g. the FullCalendar function "dayClick: function (date, jsEvent, view, resourceObj) {" uses the $scope to
set the date for the create form to the date clicked on the calendar. Since theres no ng-model in the calendar then the $scope.$apply needs to be used to update the $scopes.

Its also called when the create submit finishes successfully. Its called here because the $('#refreshList').click(); which is used to refresh the controllers list of tasks using a factory,
does not work. It throws an error Uncaught Error: [$rootScope:inprog]. So I need to call the updateListFunc() and call$scope.$apply to fire off the $watches for this. Without $scope.$apply here
the $watch will not work if updateListFunc() is called internally as there was no angular action making this happen.

If FullCalendar was properly updated to be integrated into Angular (Although V3 does not have angular support, V4 does but not for AngularJs) then there would be no need to use $scope.$spply 
*/

fetch.controller('calendarCtrl', ['$scope', '$http', 'notify', 'remove', function ($scope, $http, notify, remove) {



    $scope.updateListFunc = function () {
        remove.setListCheck(Math.random());
    }

    function eventMove(event) {

        var new_date = convertTimestamp(event.start);
        var new_start = convertTimestampToFullTime(event.start);
        var new_end = convertTimestampToFullTime(event.end);

        $.ajax({
            url: 'tasks/updateDateTime',
            type: 'POST',
            data: JSON.stringify({
                "id": event.id,
                "task_date": new_date,
                "start_time": new_start,
                "end_time": new_end
            }),
            success: function (response) {
                // messy but....
                // Angular needs an angular action to fire off watches. Cannot be done internally unless $scope.$apply is called. 
                // So the button #refreshList is tied to the function $scope.updateListFunc(). Forcing a click here will called the 
                // function using the button and fire off the watch on the list.
                $('#refreshList').click();
            }
        });
    }

    $scope.data = {};
    $scope.data.inputTaskStart = "12:00";
    $scope.data.inputTaskEnd = "12:00";
    $scope.data.types = [
        { 'id': 1, 'value': 'Meeting' },
        { 'id': 2, 'value': 'Event' },
        { 'id': 3, 'value': 'Personal' },
        { 'id': 4, 'value': 'Work' }
    ];
    $scope.selectedItem = null;
    $scope.data.inputTaskName = '';
    $scope.data.inputTaskInfo = '';
    $scope.data.inputTaskDate = '';

    $('#calendar').fullCalendar({
        height: 650,
        header: {
            right: 'month,agendaWeek,agendaDay',
            center: 'title',
            left: 'prev,next'
        },
        dayClick: function (date, jsEvent, view, resourceObj) {

            $scope.data.inputTaskDate = convertTimestamp(date.format());
            $scope.data.inputTaskStart = "12:00";
            $scope.data.inputTaskEnd = "12:00";
            $scope.data.inputTaskName = '';
            $scope.data.inputTaskInfo = '';
            $scope.data.types = [
                { 'id': 1, 'value': 'Meeting' },
                { 'id': 2, 'value': 'Event' },
                { 'id': 3, 'value': 'Personal' },
                { 'id': 4, 'value': 'Work' }
            ];
            $scope.$apply();
            openUpdate();
        },
        droppable: true,
        editable: true,
        eventDrop: function (event, delta, revertFunc, date) {
            eventMove(event);
        },
        eventResize: function (event, delta, revertFunc) {
            eventMove(event);
        },
        eventSources: [{
            events: function (start, end, timezone, callback) {
                $.ajax({
                    url: 'displayUpcomingTasks',
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        var events = [];

                        for (var i in response.tasks) {
                            var drag = true;

                            // If user didnt create the task then they cannot move it
                            if (response.tasks[i].user_id != response.user_id) {
                                drag = false;
                            }
                            var dateTimeStart = response.tasks[i].task_date + " " + response.tasks[i].start_time;
                            var dateTimeEnd = response.tasks[i].task_date + " " + response.tasks[i].end_time;

                            events.push({
                                id: response.tasks[i].id,
                                user_id: response.tasks[i].user_id,
                                title: response.tasks[i].name,
                                start: moment(dateTimeStart, 'YYYY-MM-DD hh:mm:ss'),
                                end: moment(dateTimeEnd, 'YYYY-MM-DD hh:mm:ss'),
                                description: response.tasks[i].info,
                                type: response.tasks[i].type,
                                date: response.tasks[i].task_date,
                                editable: drag,
                            });
                        }
                        callback(events);
                    }
                });
            }
        }],
        eventRender: function (event, element) {

            var date = event.date;
            var start_date = new Date(event.start);
            var start = convertTimestampToTime(start_date.toUTCString());//date1.toUTCString();

            // For an unknown reason event.end is null if set to 12pm when task is created. 
            // Null Defaults the datetime value to Thursday, 1 January 1970 00:00:00 
            // if event.end is not null then get the timestamp. If it is null set end time to not specified
            if (event.end) {
                var end_date = new Date(event.end);
                var end = convertTimestampToTime(end_date.toUTCString()); //date2.toUTCString();
            } else {
                var end = 'Not Specified';
            }

            var tooltip = '';
            if (event.type == 1) {
                element.css('background-color', '#D48D95');
                tooltip = 'qtip-red';
            } else if (event.type == 2) {
                element.css('background-color', '#56BCD8');
                tooltip = 'qtip-blue';
            } else if (event.type == 3) {
                element.css('background-color', '#68D5BD');
                tooltip = 'qtip-green';
            } else {
                element.css('background-color', '#FBD76C');
                tooltip = 'qtip-cream';
            }

            var contentInfo = '<h4 style="color:#FFFFFF; font-weight: bold">' + event.title + '</h4>' +
                '<p style="color:#FFFFFF">' + start + ' - ' + end + '</p>' +
                '<p style="color:#FFFFFF">' + event.description + '</p><br />';
            element.qtip({
                position: {
                    target: 'mouse', // Track the mouse as the positioning target
                    adjust: { x: 5, y: 5 }
                },
                show: {
                    solo: true
                },
                hide: {
                    fixed: true,
                    delay: 500
                },
                style: tooltip,
                content: contentInfo
            });
        },
        eventClick: function (event) {
            window.location.href = "tasks/task?id=" + event.id;
        }

    })

    $scope.submit = function () {

        $scope.data.inputTaskStart = $('#selector_start_create').val().replace(/\s/g, '');
        $scope.data.inputTaskEnd = $('#selector_end_create').val().replace(/\s/g, '');
        $scope.data.types = $scope.selectedItem.id;

        $http(({
            method: 'POST',
            url: '../tasks/createTask',
            data: $scope.data, //forms user object
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })).then(function (response) {
            var status = response.status;
            if (status == 200) {
                notify({ message: 'Task Created successfully' });
                $('#calendar').fullCalendar('refetchEvents');
                closeUpdate();
                $scope.updateListFunc();
                $scope.$apply;
            } else {
                notify({ message: 'Task Could Not Be Created. Please Try Again.', classes: 'alert-danger' });
            }
        });
    };
}]);


fetch.directive('modal', function () {
    return {
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
            '</div>' +
            '</div>' +
            '</div>',
        restrict: 'E',
        transclude: true,
        replace: true,
        scope: true,
        link: function postLink(scope, element, attrs) {
            scope.$watch(attrs.visible, function (value) {
                if (value == true)
                    $(element).modal('show');
                else
                    $(element).modal('hide');
            });

            $(element).on('shown.bs.modal', function () {
                scope.$apply(function () {
                    scope.$parent[attrs.visible] = true;
                });
            });

            $(element).on('hidden.bs.modal', function () {
                scope.$apply(function () {
                    scope.$parent[attrs.visible] = false;
                });
            });
        }
    };
});
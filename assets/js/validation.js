
var user = angular.module('user', ['cgNotify']);

user.controller('indexCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {
    
    //$scope.user = [{email: '', password: ''}];

    $scope.login = function(){
        $http(({
                method: 'POST',
                url: 'users/login',
                data: $scope.user, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
            var status = response.data;
                if(status.code == 200){
                    window.location.href = "users/index"; 
                } else {
                    notify({ message:status.response, classes: 'alert-danger'} );
                } 
            });
    }

    $scope.register = function(){
        $http(({
                method: 'POST',
                url: 'users/register',
                data: $scope.user, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
            var status = response.data;
                if(status.code == 200){
                    window.location.href = "users/index"; 
                } else {
                    notify({message:status.response, classes: 'alert-danger'} );
                } 
            });
    }


    $scope.recover = function(){

        $http(({
                method: 'POST',
                url: 'users/recoverPassword',
                data: $scope.recover.email, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
            var status = response.data;
                if(status.code == 200){
                    notify({ message:status.response} );
                    window.setTimeout(function(){window.location.href = "users/index"},1000); 
                } else {
                    notify({message:status.response, classes: 'alert-danger'} );
                } 
            });
    }

    $scope.validate_recover = function(){

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

        var token = getQueryVariable("tok");

        $http(({
                method: 'POST',
                url: 'users/validateRecoverPassword?tok=' + token,
                data: $scope.validate.reset_password, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
            var status = response.data;
                if(status.code == 200){
                    notify({ message:status.response} );
                    window.setTimeout(function(){window.location.href = "users/index"},1000); 
                } else {
                    notify({message:status.response, classes: 'alert-danger'} );
                } 
            });

    }

}]);


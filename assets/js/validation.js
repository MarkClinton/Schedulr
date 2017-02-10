
var user = angular.module('user', ['cgNotify']);

user.controller('loginCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {
    
    //$scope.user = [{email: '', password: ''}];

    $scope.login = function(){
        $http(({
                method: 'POST',
                url: 'users/login',
                data: $scope.user, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
            var status = response.data;
                if(status == 200){
                    window.location.href = "users/index"; 
                } else {
                    notify({ message:'Wrong Username / Password', classes: 'alert-danger'} );
                } 
            });
    }

}]);

user.controller('registerCtrl', ['$scope', '$http', 'notify', function ($scope, $http, notify) {

    $scope.register = function(){
        $http(({
                method: 'POST',
                url: 'users/register',
                data: $scope.user, //forms user object
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })).then(function (response) {
            var status = response.data;
                if(status == 200){
                    window.location.href = "login"; 
                } else {
                    notify({ message:'Wrong Username / Password'} );
                } 
            });
    }

    }]);


var file = angular.module('fileService', []);

//var f = angular.module('file', []);

//ng-model does not provide 2 way binding for file fields. This directive provides the missing binding 
//needed to access file contents.
file.directive('fileModel', function ($parse) {
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
file.factory('uploadFileData', ['$http', function($http) {
    return{
        fileToUrl: function(file, url, fileName){
            var fd = new FormData();
            var data = {};

            if(url === "fileUpload"){
                fd.append('file', file[0]['file']);
                fd.append('name', file[0]['fileName']);

                var task_id = file[0]['task_id'];
                var uploaded_by = file[0]['admin'];

                data.task_id = task_id;
                data.uploaded_by = uploaded_by;

                fd.append('data', JSON.stringify(data));
                
            }else{
                fd.append('file', file);
                fd.append('name', fileName);
            }

            return $http(({
                    method: 'POST',
                    url: url,
                    data: fd, //forms user object
                    headers: {'Content-Type': undefined}
                })).then(function (result) {
                    return result.status;
                });
        }
    }
}]);
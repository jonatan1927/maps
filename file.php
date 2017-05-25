<!--<html>
    <head>
        <meta charset="utf-8">
        <title>AngularJS / Google Maps Tutorial</title>

        <script src="js/lib/angularjs.min.js?v=1.2.26"></script>
         shim is needed to support non-HTML5 FormData browsers (IE8-9)
        <script src="node_modules/ng-file-upload/dist/ng-file-upload-shim.min.js"></script>
        <script src="node_modules/ng-file-upload/dist/ng-file-upload.min.js"></script>

        <script src="js/upload.js"></script>
    </head>
    <body ng-app="fileUpload" ng-controller="MyCtrl">
            <form name="myForm">
            <fieldset>
                <legend>Upload on form submit</legend>
                Username:
                <input type="text" name="userName" ng-model="username" size="31" required>
                <i ng-show="myForm.userName.$error.required">*required</i>
                <br>Photo:
                <input type="file" ngf-select ng-model="picFile" name="file"    
                       accept="image/*" ngf-max-size="2MB" required
                       ngf-model-invalid="errorFile">
                <i ng-show="myForm.file.$error.required">*required</i><br>
                <i ng-show="myForm.file.$error.maxSize">File too large 
                    {{errorFile.size / 1000000|number:1}}MB: max 2M</i>
                <img ng-show="myForm.file.$valid" ngf-thumbnail="picFile" class="thumb"> <button ng-click="picFile = null" ng-show="picFile">Remove</button>
                <br>
                <button ng-disabled="!myForm.$valid" 
                        ng-click="upload(picFile)">Submit</button>
                <span class="progress" ng-show="picFile.progress >= 0">
                    <div style="width:{{picFile.progress}}%" 
                         ng-bind="picFile.progress + '%'"></div>
                </span>
                <span ng-show="picFile.result">Upload Successful</span>
                <span class="err" ng-show="errorMsg">{{errorMsg}}</span>
            </fieldset>
            <br>
        </form>
    </body>
</html>
-->
<html>

    <head>
        <script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    </head>

    <body ng-app = "myApp">

        <div ng-controller = 'myCtrl'>

            <input type = 'file' file-model = 'myFile'/>

            <button ng-click = 'uploadFile()'>upload me</button>

        </div>

        <script>
            var myApp = angular.module('myApp', []);



            myApp.directive('fileModel', ['$parse', function ($parse) {

                    return {

                        restrict: 'A',

                        link: function (scope, element, attrs) {

                            var model = $parse(attrs.fileModel);

                            var modelSetter = model.assign;



                            element.bind('change', function () {

                                scope.$apply(function () {

                                    modelSetter(scope, element[0].files[0]);

                                });

                            });

                        }

                    };

                }]);



            myApp.service('fileUpload', ['$http', function ($http) {

                    this.uploadFileToUrl = function (file, uploadUrl) {

                        var fd = new FormData();

                        fd.append('file', file);



                        $http.post(uploadUrl, fd, {

                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined}

                        })



                                .success(function () {

                                })



                                .error(function () {

                                });

                    }

                }]);



            myApp.controller('myCtrl', ['$scope', 'fileUpload', function ($scope, fileUpload) {

                    $scope.uploadFile = function () {

                        var file = $scope.myFile;



                        console.log('file is ');

                        console.dir(file);



                        var uploadUrl = 'php';

                        fileUpload.uploadFileToUrl(file, uploadUrl);

                    };

                }]);

        </script>

    </body>
</html>
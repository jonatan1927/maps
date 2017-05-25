var app = angular.module('fileUpload', ['ngFileUpload']);

app.controller('MyCtrl', ['$scope', 'Upload', '$timeout','$http', function ($scope, Upload, $timeout, $http) {
    $scope.uploadPic = function(file) {
    file.upload = Upload.upload({
      url: '',
      data: {username: $scope.username, file: file},
    });

    file.upload.then(function (response) {
      $timeout(function () {
        file.result = response.data;
      });
    }, function (response) {
      if (response.status > 0)
        $scope.errorMsg = response.status + ': ' + response.data;
    }, function (evt) {
      // Math.min is to fix IE which reports 200% sometimes
      file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
    });
    };
//$scope.upload = function(files) {
//   if (files && files.length) {
//     for (var i = 0; i < files.length; i++) {
//       var file = files[i];
//       if (!file.$error) {
//         file.upload = Upload.http({
//           url: '',
//           method: 'POST',
//           headers: {
//             'Content-type': 'application/json',
//             'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
//           },
//           data: {
//             file: file,
//             db: 'BigQuery'
//           }
//         });
//         file.upload.then(function(response) {
//           file.result = response.data;
//         }, function(response) {
//           if (response.status > 0)
//             $scope.errorMsg = response.status + ': ' + response.data;
//         });
//         file.upload.progress(function(evt) {
//           file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
//         });
//       }
//     }
//   }
// };
}]);
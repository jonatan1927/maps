var app = angular.module('AngularGoogleMap', ['google-maps']);

app.factory('MarkerCreatorService', function () {

    var markerId = 0;

    function create(latitude, longitude) {
        var marker = {
            options: {
                animation: 1,
                labelAnchor: "28 -5",
                labelClass: 'markerlabel'
            },
            latitude: latitude,
            longitude: longitude,
            id: ++markerId
        };
        return marker;
    }

    function invokeSuccessCallback(successCallback, marker) {
        if (typeof successCallback === 'function') {
            successCallback(marker);
        }
    }

    function createByCoords(latitude, longitude, successCallback) {
        var marker = create(latitude, longitude);
        invokeSuccessCallback(successCallback, marker);
    }

    function createByAddress(address, successCallback) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var firstAddress = results[0];
                var latitude = firstAddress.geometry.location.lat();
                var longitude = firstAddress.geometry.location.lng();
                var marker = create(latitude, longitude);
                invokeSuccessCallback(successCallback, marker);
            } else {
                alert("Unknown address: " + address);
            }
        });
    }

    function createByCurrentLocation(successCallback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var marker = create(position.coords.latitude, position.coords.longitude);
                invokeSuccessCallback(successCallback, marker);
            });
        } else {
            alert('Unable to locate current position');
        }
    }

    return {
        createByCoords: createByCoords,
        createByAddress: createByAddress,
        createByCurrentLocation: createByCurrentLocation
    };

});

app.controller('MapCtrl', ['MarkerCreatorService', '$scope', '$http', function (MarkerCreatorService, $scope, $http) {

        MarkerCreatorService.createByCoords(4.354018, -75.1259800, function (marker) {
//            marker.options.labelContent = 'Autentia';
            $scope.autentiaMarker = marker;
        });

        $scope.address = '';
        $scope.plones = '';

        $scope.map = {
            center: {
                latitude: $scope.autentiaMarker.latitude,
                longitude: $scope.autentiaMarker.longitude
            },
            zoom: 8,
            markers: [],
            control: {},
            options: {
                scrollwheel: false
            }
        };

//        $scope.map.markers.push($scope.autentiaMarker);

        $scope.addCurrentLocation = function () {
            MarkerCreatorService.createByCurrentLocation(function (marker) {
                marker.options.labelContent = 'You´re here';
                $scope.map.markers.push(marker);
                refresh(marker);
            });
        };

        $scope.addAddress = function () {
            var address = $scope.address;
            if (address !== '') {
                MarkerCreatorService.createByAddress(address, function (marker) {
                    $scope.map.markers.push(marker);
                    refresh(marker);
                });
            }
        };

        function refresh(marker) {
            $scope.map.control.refresh({latitude: marker.latitude,
                longitude: marker.longitude});
        }
        $scope.addPointsFile = function () {

                var latitud = $("#latitud").val().substring(0,$("#latitud").val().length - 1);
                var longitud = $("#longitud").val().substring(0,$("#longitud").val().length - 1);        
                var lat = latitud.split(";");
                var lon = longitud.split(";");
                
            angular.forEach(lat, function (value, key) {
                MarkerCreatorService.createByCoords(lat[key], lon[key], function (marker) {
//                    marker.options.labelContent = 'esta es';
                    $scope.map.markers.push(marker);
                    refresh(marker);
                });
            });
            
        };

    }]);



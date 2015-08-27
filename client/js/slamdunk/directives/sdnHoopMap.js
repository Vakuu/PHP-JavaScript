angular.module('slamdunk')
  .directive('sdnHoopMap', function(sdnVersion) {
    return {
      restrict: 'E',
      templateUrl: sdnVersion + "/templates/directive-templates/sdn-hoop-map.html",
      link: function(scope, element, attrs, ctrl) {
        console.log("sdnhoopmap directive init");
        scope.myMarkers = [];
        var google = window.google;
        scope.mapOptions = {
          center: new google.maps.LatLng(35.784, -78.670),
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        scope.addMarker = function($event, $params) {
          // scope.myMarkers.push(new google.maps.Marker({
          //   map: $scope.myMap,
          //   position: $params[0].latLng
          // }));
        };

        scope.setZoomMessage = function(zoom) {
          scope.zoomMessage = 'You just zoomed to ' + zoom + '!';
          console.log(zoom, 'zoomed')
        };

        scope.openMarkerInfo = function(marker) {
          scope.currentMarker = marker;
          scope.currentMarkerLat = marker.getPosition().lat();
          scope.currentMarkerLng = marker.getPosition().lng();
          scope.myInfoWindow.open($scope.myMap, marker);
        };

        scope.setMarkerPosition = function(marker, lat, lng) {
          marker.setPosition(new google.maps.LatLng(lat, lng));
        };
      }
    }
  });
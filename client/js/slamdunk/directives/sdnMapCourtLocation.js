angular.module('slamdunk')
  .directive('sdnMapCourtLocation', ['$rootScope', 'loader', '$templateCache', 'courts_factory', 'geolocation', 'user', 'sharing', '$window', '$timeout', 'sdnVersion',
    function($rootScope, loader, $templateCache, courts_factory, geolocation, user, sharing, $window, $timeout, sdnVersion) {
      'use strict';
      return {
        restrict: 'E',
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-map-court-location.html",
        link: function($scope, element, attrs, ctrl) {
          'use strict';

          $scope.courts = [];
          $scope.myMarkers = [];

          //All Maps functions
          var google = window.google;

          //All hoopmap Utils functions
          var hoopmapUtils = {
            drawMarker: function(latLang, isDraggable, court, isNewCourt) {
              var markerLabel;
              //'<div class="hoopmap-courtking-img"></div><i class="hoopmap-marker-img icon marker_'+ (court ? court.ctype : 'indoor') +'_black"></i>' + (court ? '<i class="hoopmap-icon">'+ (court.checks ? court.checks.length : 0) +'</i>' : '')

              if (isNewCourt) {
                markerLabel = '<i class="hoopmap-marker-img icon marker_' + (court ? court.ctype : 'indoor') + '_orange"></i>';
              } else {
                //http://squizzes.s3.amazonaws.com/wp-content/uploads/2012/08/King-Henry-II-bullet.jpg
                var kingOfCourt = court.king ? '<img src="' + court.king.photo_t_url + '"/>' : "";
                markerLabel = '<div class="hoopmap-courtking-img">' + kingOfCourt + '</div><i class="hoopmap-marker-img icon marker_' + (court ? court.ctype : 'indoor') + '_black"></i>' + (court ? '<i class="hoopmap-icon">' + (court.playersOnCourtToday ? court.playersOnCourtToday.length : 0) + '</i>' : '');
              }

              var newMarker = new Marker({
                map: $scope.myMap,
                position: latLang,
                draggable: isDraggable,
                animation: google.maps.Animation.BOUNCE,
                zIndex: 9,
                icon: {
                  path: SQUARE_PIN,
                  fillColor: 'transparent',
                  fillOpacity: 1,
                  strokeColor: '',
                  strokeWeight: 0,
                  scale: 1 / 3,
                  anchor: new google.maps.Point(-50, 45)
                },
                //label: '<div class="hoopmap-courtking-img"></div><i class="hoopmap-marker-img icon marker_'+ (court ? court.ctype : 'indoor') +'_black"></i>' + (court ? '<i class="hoopmap-icon">'+ (court.checks ? court.checks.length : 0) +'</i>' : '')
                label: markerLabel
              });


              //change create court address based on marker position
              google.maps.event.addListener(newMarker, 'dragend', function(data) {

              });

              if (isNewCourt) {};

              return newMarker;
            },
            removeMarker: function(marker, index) {
              $scope.myMarkers.splice(index, 1);
              marker.setMap(null);
              marker = null;
              index = null;
            }
          };

          var initMarkers = function() {
            angular.forEach($scope.courts, function(currCourt) {
              var latLng = new google.maps.LatLng(currCourt.loc[1], currCourt.loc[0]);
              var marker = hoopmapUtils.drawMarker(latLng, false, currCourt);
              marker.metadata = {
                court: currCourt
              };
              $scope.myMarkers.push(marker);
            });
          };

          $scope.onMapIdle = function() {
            if ($scope.myMarkers === undefined) {
              $scope.myMarkers = [];
              initMarkers();
            }
          };

          /// We have used Angular UI Map (http://angular-ui.github.io/ui-map/) 
          /// For all the Google Map operation
          /// You can visit http://angular-ui.github.io/ui-map/ For more information

          ///All Angular UI Methods

          //Hoopmap center will be based upon user location

          ///google.maps.MapOptions object specification
          ///https://developers.google.com/maps/dns.resolve(domain, type_, callback_);umentation/javascript/reference#MapOptions
          var bounds = new google.maps.LatLngBounds();
          $scope.myLocationLoad = function() {

            user.location(function(loc) {

              var bounds = new google.maps.LatLngBounds();
              var newll = new google.maps.LatLng(loc.lat, loc.lng);


              $scope.myMap.fitBounds(bounds);
              $scope.myMap.setCenter(newll);

              courts_factory.nearbyCourts({
                lat: loc.lat,
                lng: loc.lng
              }).success(function(result) {

                $scope.courts = result;
                initMarkers();

              }).error(function(err) {});

            }, function() {

              var newll = new google.maps.LatLng(40.569662, -73.858206);
              $scope.myMap.setCenter(newll);

            });

          };

          $scope.myLocationLoad();

          $scope.mapOptions = {
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            animation: google.maps.Animation.DROP
          };

          //Set google map center using Lat Lng
          $scope.setMarkerPosition = function(marker, lat, lng) {
            marker.setPosition(new google.maps.LatLng(lat, lng));
          };

          //Display court ditails on marker click
          $scope.openMarkerInfo = function(marker) {
            if (marker.metadata) {

              $('.hoopmap-tabs a[data-target="#mapdata"]').tab('show');

              $scope.selectedCourtInfo = marker.metadata.court || {};


            } else {
              $('.hoopmap-tabs a[data-target="#courtcreate"]').tab('show');
            }
          };


          $scope.setZoomMessage = function(zoom) {
            $scope.zoomMessage = "You just zoomed to " + zoom + "!";
          };


          $scope.setAddressLocationandZoom = function(address, zoom) {
            globalClass.getLatLongFromAddress($scope.filter.country, function(results) {
              var obj = results[0].geometry.location;
              var newll = new google.maps.LatLng(obj.A, obj.k);
              $scope.myMap.setCenter(obj);
              $scope.myMap.setZoom(15);
            });
          };

        }
      };
    }
  ]);
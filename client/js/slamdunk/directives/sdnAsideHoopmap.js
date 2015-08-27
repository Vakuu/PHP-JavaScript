// angular.module('slamdunk')
//   .directive('sdnAsideHoopmap', ['$rootScope', 'loader', '$templateCache', 'courts_factory', 'geolocation', 'user', 'sharing', '$window', '$timeout', 'sdnVersion',
//     function($rootScope, loader, $templateCache, courts_factory, geolocation, user, sharing, $window, $timeout, sdnVersion) {
//       'use strict';
//       return {
//         restrict: "E",
//         templateUrl: sdnVersion + "/templates/directive-templates/sdn-aside-hoopmap.html",
//         link: function($scope, element, attrs, ctrl) {
//           'use strict';

//           $scope.courts = [];
//           $scope.myMarkers = [];

//           //All Maps functions
//           var google = window.google;
// 
//
//           //All hoopmap Utils functions
//           var hoopmapUtils = {
//             drawMarker: function(latLang, isDraggable, court, isNewCourt) {
//               var markerLabel;
//               //'<div class="hoopmap-courtking-img"></div><i class="hoopmap-marker-img icon marker_'+ (court ? court.ctype : 'indoor') +'_black"></i>' + (court ? '<i class="hoopmap-icon">'+ (court.checks ? court.checks.length : 0) +'</i>' : '')

//               if (isNewCourt) {
//                 markerLabel = '<i class="hoopmap-marker-img icon marker_' + (court ? court.ctype : 'indoor') + '_orange"></i>';
//               } else {
//                 //http://squizzes.s3.amazonaws.com/wp-content/uploads/2012/08/King-Henry-II-bullet.jpg
//                 var kingOfCourt = court.king ? '<img src="' + court.king.photo_t_url + '"/>' : "";
//                 markerLabel = '<div class="hoopmap-courtking-img">' + kingOfCourt + '</div><i class="hoopmap-marker-img icon marker_' + (court ? court.ctype : 'indoor') + '_black"></i>' + (court ? '<i class="hoopmap-icon">' + (court.playersOnCourtToday ? court.playersOnCourtToday.length : 0) + '</i>' : '');
//               }

//               var newMarker = new Marker({
//                 map: $scope.myMap,
//                 position: latLang,
//                 draggable: isDraggable,
//                 animation: google.maps.Animation.BOUNCE,
//                 zIndex: 9,
//                 icon: {
//                   path: SQUARE_PIN,
//                   fillColor: 'transparent',
//                   fillOpacity: 1,
//                   strokeColor: '',
//                   strokeWeight: 0,
//                   scale: 1 / 3,
//                   anchor: new google.maps.Point(-50, 45)
//                 },
//                 //label: '<div class="hoopmap-courtking-img"></div><i class="hoopmap-marker-img icon marker_'+ (court ? court.ctype : 'indoor') +'_black"></i>' + (court ? '<i class="hoopmap-icon">'+ (court.checks ? court.checks.length : 0) +'</i>' : '')
//                 label: markerLabel
//               });


//               //change create court address based on marker position
//               google.maps.event.addListener(newMarker, 'dragend', function(data) {

//               });

//               if (isNewCourt) {};

//               return newMarker;
//             },
//             removeMarker: function(marker, index) {
//               $scope.myMarkers.splice(index, 1);
//               marker.setMap(null);
//               marker = null;
//               index = null;
//             }
//           };

//           var initMarkers = function() {
//             angular.forEach($scope.courts, function(currCourt) {
//               var latLng = new google.maps.LatLng(currCourt.loc[1], currCourt.loc[0]);
//               var marker = hoopmapUtils.drawMarker(latLng, false, currCourt);
//               marker.metadata = {
//                 court: currCourt
//               };
//               $scope.myMarkers.push(marker);
//             });
//           };

//           $scope.onMapIdle = function() {
//             if ($scope.myMarkers === undefined) {
//               $scope.myMarkers = [];
//               initMarkers();
//             }
//           };

//           /// We have used Angular UI Map (http://angular-ui.github.io/ui-map/) 
//           /// For all the Google Map operation
//           /// You can visit http://angular-ui.github.io/ui-map/ For more information

//           ///All Angular UI Methods

//           //Hoopmap center will be based upon user location

//           ///google.maps.MapOptions object specification
//           ///https://developers.google.com/maps/dns.resolve(domain, type_, callback_);umentation/javascript/reference#MapOptions
//           var bounds = new google.maps.LatLngBounds();

//           $scope.loadDataFromIPLocation = function() {

//             user.activeUser().success(function(u) {
//               var au = u;

//               var bounds = new google.maps.LatLngBounds();
//               var newll = new google.maps.LatLng(au.iplocation.loc[0], au.iplocation.loc[1]);


//               $scope.myMap.fitBounds(bounds);
//               $scope.myMap.setCenter(newll);

//               courts_factory.nearbyCourts({
//                 lat: au.iplocation.loc[1],
//                 lng: au.iplocation.loc[0]
//               }).success(function(result) {

//                 $scope.courts = result;
//                 initMarkers();

//               }).error(function(err) {});

//             }).error(function() {

//             });
//           };

//           $scope.myLocationLoad = function() {

//             user.location(function(loc) {

//               var bounds = new google.maps.LatLngBounds();
//               var newll = new google.maps.LatLng(loc.lat, loc.lng);

//               $scope.myMap.fitBounds(bounds);
//               $scope.myMap.setCenter(newll);

//               courts_factory.nearbyCourts({
//                 lat: loc.lat,
//                 lng: loc.lng
//               }).success(function(result) {

//                 $scope.courts = result;
//                 initMarkers();
//                 $scope.myMap.setZoom(14);

//               }).error(function(err) {});

//             }, function() {
//               var newll = new google.maps.LatLng(40.569662, -73.858206);
//               $scope.myMap.setCenter(newll);

//             });
//             //$scope.loadDataFromIPLocation();
//           };

//           $scope.myLocationLoad();

//           $scope.mapOptions = {
//             zoom: 24,
//             mapTypeId: google.maps.MapTypeId.ROADMAP,
//             animation: google.maps.Animation.DROP
//           };

//           //Set google map center using Lat Lng
//           $scope.setMarkerPosition = function(marker, lat, lng) {
//             marker.setPosition(new google.maps.LatLng(lat, lng));
//           };

//           //Display court ditails on marker click
//           $scope.openMarkerInfo = function(marker) {
//             if (marker.metadata) {

//               $('.hoopmap-tabs a[data-target="#mapdata"]').tab('show');

//               $scope.selectedCourtInfo = marker.metadata.court || {};
//               defaultButtonVisiblity();

//             } else {
//               $('.hoopmap-tabs a[data-target="#courtcreate"]').tab('show');
//             }
//           };


//           $scope.setZoomMessage = function(zoom) {
//             $scope.zoomMessage = "You just zoomed to " + zoom + "!";
//           };

//           //
//           $scope.addMarker = function($event, $params) {

//             // //fill address information on new markup addition
//             // fillAddressFields({
//             //   lat: $params[0].latLng.k,
//             //   lng: $params[0].latLng.A
//             // });

//             // //Remove marker if any one exist which is not saved
//             // if ($scope.activeMarker) {
//             //   hoopmapUtils.removeMarker($scope.activeMarker, $scope.activeMarkerIndex);
//             // }

//             // //Create new marker
//             // var marker = hoopmapUtils.drawMarker($params[0].latLng, true, $scope.court, true);
//             // $scope.myMarkers.push(marker);
//             // $scope.activeMarker = marker;
//             // $scope.activeMarkerIndex = $scope.myMarkers.length - 1;

//             // $('.hoopmap-tabs a[data-target="#courtcreate"]').tab('show');
//           };

//           $scope.setAddressLocationandZoom = function(address, zoom) {
//             globalClass.getLatLongFromAddress($scope.filter.country, function(results) {
//               var obj = results[0].geometry.location;
//               var newll = new google.maps.LatLng(obj.A, obj.k);
//               $scope.myMap.setCenter(obj);
//             });
//           };

//         }
//       };
//     }
//   ]);

angular.module('slamdunk')
  .directive('sdnAsideHoopmap', ['$rootScope', 'loader', '$templateCache', 'courts_factory', 'geolocation', 'user', 'sharing', '$window', '$timeout', 'sdnVersion',
    function($rootScope, loader, $templateCache, courts_factory, geolocation, user, sharing, $window, $timeout, sdnVersion) {
      'use strict';
      return {
        restrict: "AE",
        //templateUrl: sdnVersion + "/templates/directive-templates/sdn-aside-hoopmap.html",
        link: function(scope, element, attrs, ctrl) {

          user.location(function(loc) {
            var newll = new google.maps.LatLng(loc.lat, loc.lng);
            scope.map.setCenter(newll);
          }, function() {
            var newll = new google.maps.LatLng($rootScope.activeUser.iplocation.loc[0], $rootScope.activeUser.iplocation.loc[1])
            scope.map.setCenter(newll);
          });

          scope.mapOptions = {
            center: new google.maps.LatLng(-34.397, 150.644),
            zoom: 8,
            styles: [{
              stylers: [{
                visibility: 'simplified'
              }]
            }, {
              elementType: 'labels',
              stylers: [{
                visibility: 'off'
              }]
            }]
          };

          scope.addMarker = function(c) {
            
            scope.marker1 = new MarkerWithLabel({
              position: new google.maps.LatLng(c.loc[1], c.loc[0]),
              draggable: true,
              map: scope.map,
              //labelContent: '<i class="active_player_marker">0</i>',
              labelContent: '<i class="hoopmap-marker-img icon marker_street_orange"><i class="active_player_marker">15</i></i>',
              labelAnchor: new google.maps.Point(22, 0),
              labelClass: "labels", // the CSS class for the label
              labelStyle: {
                opacity: 0.75
              },
              icon: {
                //url: ''
              }
            });

            scope.marker1.setMap(scope.map);
          }
          
          scope.initialize = function() {
            

            courts_factory.filter({}).success(function(c) {
              ////
             
              for(var i = 0; i < c.length; i++) {
                scope.addMarker(c[i]);  
              }
              
              ////
            }).error(function(err) {

            });

            
            scope.map = new google.maps.Map(document.getElementById(attrs.id), scope.mapOptions);

          };

          scope.initialize();

          //google.maps.event.addDomListener(window, 'load', scope.initialize);

        }
      };
    }
  ]);
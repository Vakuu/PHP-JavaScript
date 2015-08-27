angular.module('slamdunk')
  .controller('EditCourtCtrl', ['$scope', '$rootScope', 'loader', '$templateCache', 'courts_factory', 'geolocation', 'user', 'sharing', '$window', '$timeout', 'courtInfo', '$location',
    function($scope, $rootScope, loader, $templateCache, courts_factory, geolocation, user, sharing, $window, $timeout, courtInfo, $location) {
      'use strict';

      $scope.court = courtInfo;
      //
      // delete $scope.court.albums;
      // delete $scope.court.checks;
      // delete $scope.court.deleted;
      // delete $scope.court.events;
      // delete $scope.court.fake;
      // delete $scope.court.games;
      // delete $scope.court.playersAttendingToday;
      // delete $scope.court.playersOnCourtToday;
      // delete $scope.court.userId;
      // delete $scope.court["__v"];

      $scope.editCourtProfile = function() {


        courts_factory.update($scope.court).success(function(data) {
          $scope.alerts.push({
            type: 'success',
            msg: 'Court is updated!'
          });
          $location.path( "/court-profile/" + $scope.court._id );
        }).error(function(err) {
          $scope.alerts.push({
            type: 'danger',
            msg: 'Error while processing!'
          });
        });

      };



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
            fillAddressFields({
              lat: data.latLng.k,
              lng: data.latLng.A
            });
          });

          if (isNewCourt) {};

          return newMarker;
        },
        removeMarker: function(marker, index) {
          $scope.myMarkers = [];

          marker = null;
          index = null;
        }
      };

      var marker;
      var initMarkers = function() {
        angular.forEach($scope.courts, function(currCourt) {
          var latLng = new google.maps.LatLng(currCourt.loc[1], currCourt.loc[0]);
          marker = hoopmapUtils.drawMarker(latLng, true, currCourt);
          marker.metadata = {
            court: currCourt
          };
          $scope.myMarkers.push(marker);
        });
      };

      $scope.onMapIdle = function() {
        if ($scope.myMarkers === undefined) {
          $scope.myMarkers = [];
          //initMarkers();
          //$scope.myLocationLoad();
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
        $timeout(function() {

          $scope.courts.push(courtInfo);
          initMarkers();
        }, 0);
      };
      $scope.myLocationLoad();

      $scope.mapOptions = {
        zoom: 18,
        center: new google.maps.LatLng(courtInfo.loc[1], courtInfo.loc[0]),
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

      $scope.addMarker = function($event, $params) {

        // //fill address information on new markup addition
        fillAddressFields({
          lat: $params[0].latLng.k,
          lng: $params[0].latLng.A
        });

        //Remove marker if any one exist which is not saved
        hoopmapUtils.removeMarker();

        //Create new marker
        //var marker = hoopmapUtils.drawMarker($params[0].latLng, true, courtInfo, true);
        marker.setPosition($params[0].latLng);

      };


      //Fill address field based on LatLng
      function fillAddressFields(latLng) {
        $scope.court.address = {};
        $scope.loadingAddress = true;

        $scope.court.loc = [latLng.lng, latLng.lat];

        $scope.frmEdit.$setDirty();

        geolocation.getPlace(latLng, function(loc) {
          $scope.court.address = {
            street: loc.address,
            city: loc.city,
            country: loc.country
          };
          $scope.myMap.setZoom(15);

          $scope.loadingAddress = false;
        });
      };



      $scope.setZoomMessage = function(zoom) {
        $scope.zoomMessage = "You just zoomed to " + zoom + "!";
      };


      $scope.setAddressLocationandZoom = function(address, zoom) {
        globalClass.getLatLongFromAddress($scope.filter.country, function(results) {
          var obj = results[0].geometry.location;
          var newll = new google.maps.LatLng(obj.A, obj.k);
          $scope.myMap.setCenter(obj);
          $scope.myMap.setZoom(20);
        });
      };


      $scope.profilePicChanged = function(url) {
        $scope.imgLoading = false;
        $scope.court.mainImage.image_large_url = url;
      };

      $scope.profPicUploadStart = function() {
        $scope.imgLoading = true;
      };

    }
  ]);
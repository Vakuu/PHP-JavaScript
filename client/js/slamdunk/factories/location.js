'use strict'
angular.module('slamdunk')
  .factory('geolocation', ['$window', '$http', 'token',
    function($window, $http, token) {

      return {

        //get lat-lng of current user
        currentPosition: function() {},

        //get place information of current user
        currentPlace: function(cb) {
          var loc = loc || {};
          $window.navigator.geolocation.getCurrentPosition(function(position) {
            ///if user allows to share location
            loc.lat = position.coords.latitude;
            loc.lng = position.coords.longitude;
            globalClass.getGeocodeData({
              lat: loc.lat,
              lng: loc.lng
            }, function(info) {
              cb(info);
            });

          }, function(error) {
            //globalClass.getGeocodeData();
            arguments[1](error);
          });
        },

        //get place information using lat-lng
        getPlace: function() {
          var loc = arguments[0],
            callback = arguments[1];
          globalClass.getGeocodeData({
            lat: loc.lat,
            lng: loc.lng
          }, function(info) {
            callback(info);
          });
        },

        searchCountries: function() {
          return $http.get("http://sdapi.herokuapp.com/countries/q/" + arguments[0] + "?access_token=" + token.get);
        }

      }

    }
  ]);
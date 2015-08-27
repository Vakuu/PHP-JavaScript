'use strict';
angular.module('slamdunk')
  .factory('user', ['$http', 'api_url', 'token', '$window',
    function($http, api_url, token, $window) {

      var storeActiveUser = function(obj) {
        localStorage.activeUser = JSON.stringify(obj);
      }

      return {

        profileProgress: function(user) {
          user = JSON.parse($window.localStorage.activeUser);
          var total = 14,
            filled = 0;
          console.log(user, "this is user");
          if (user.fname)
            filled++;

          if (user.photo)
            filled++;

          if (user.lname)
            filled++;

          if (user.gender)
            filled++;

          if (user.dob)
            filled++;

          if (user.height)
            filled++;

          if (user.weight)
            filled++;

          if (user.level)
            filled++;

          if (user.position)
            filled++;

          if (user.address) {
            if (user.address.country)
              filled++;

            if (user.address.state)
              filled++;

            if (user.address.street)
              filled++;

            if (user.address.city)
              filled++;

            if (user.address.zip)
              filled++;
          }
          return parseInt(filled / total * 100);

        },
        //get active user information
        activeUser: function(cb, err, update) {
          if($window.localStorage.activeUser && !update) {
            if(cb)
              cb(JSON.parse($window.localStorage.activeUser));
          } else {
            $http
              .get(api_url + '/user?access_token=' + token.get)
              .success(function(r) {
                //localStorage.activeUser = JSON.stringify(r);
                storeActiveUser(r);
                //onsole.log($window.localStorage.activeUser);
                cb(JSON.parse($window.localStorage.activeUser));
              })
              .error(function(msg) {
                err(msg);
              });
          }
        },

        updateActiveUser: function(obj) {
          storeActiveUser(obj);
        },

        //get user information
        get: function() {

          var param = arguments[0];

          if (!param) {
            //throw error
            console.error('Please supply name, email or id');
          } else if (param.email) {
            //get user using emaill address
            ///users/q/:email
            return $http.get(api_url + '/users/q/' + param.email + '?access_token=' + token.get);
          } else if (param.name) {
            //get user using name
            ///users/q/:name
            return $http.get(api_url + '/users/q/' + param.name + '?access_token=' + token.get);
          } else if (param.id) {
            //get user using id
            return $http.get(api_url + '/user/' + param.id + '?access_token=' + token.get);
          }

        },

        getById: function(uid) {
          //5366acbda22481020033a5bb
          return $http.get(api_url + '/user/' + uid + '?access_token=' + token.get);
        },

        //get by token
        getByToken: function(t) {
          return $http.get(api_url + '/user?access_token=' + t);
        },

        //create new user 
        create: function(user) {
          //

          return $http.post(api_url + '/users?access_token=' + token.get, user);
        },

        //update user
        update: function() {

          var id = arguments[0]._id;

          var _user = {
            user: arguments[0]
          };
          var params = arguments[0];
          console.log(params);
          var newObject = {
            "user": {
              "fname": params.fname,
              "lname": params.lname,
              "dob": params.dob,
              "email": params.email,
              "gender": params.gender,
              "level": params.level,
              "height": params.height,
              "height_unit": "m",
              "weight": params.weight,
              "weight_unit": "kg",
              "position": params.position,

              "address": {
                "city": params.address.city,
                "country": params.address.country,
                "state": params.address.state,
                "street": params.address.street,
                "zip": params.address.zip
              }
            }
          };
          var result = $http.put(api_url + '/user/' + id + '?access_token=' + token.get, newObject);
          result.success(function(data) {
            storeActiveUser(data);
            //localStorage.activeUser = JSON.stringify(data);
          });
          return result;
        },

        //delete user
        delete: function() {
          return $http.delete(api_url + '/user/' + arguments[0] + '?access_token=' + token.get);
        },

        //check user existince using emaill address
        isExist: function() {
          return $http.get(api_url + '/users/exists/' + arguments[0] + '?access_token=' + token.get);
        },

        profile: function() {

          var data = {
            _id: "_234jkjkfjdsa932489klmjsaf",
            name: "Hargovind Sureshbhai Dodiya",
            age: 22
          }
          arguments[0](data);
          //return $http.get('/user/:id');
        },

        getLocation: function() {
          // return geolocation.currentPlace(function(){

          // });
        },
        //get location of current user using HTML5 GeoLocation API

        location: function(cb, err) {
          var loc = {};
          $window.navigator.geolocation.getCurrentPosition(function(position) {

            ///use HTML5 Geolocation API
            ///if user allows to share location
            loc.lat = position.coords.latitude;
            loc.lng = position.coords.longitude;
            cb(loc);

          }, function(error) {
            err();
          });

        },

        html5location: function() {
          $window.navigator.geolocation.getCurrentPosition(function(position) {
            arguments[0](position);
          }, function(error) {
            arguments[1](error);
          });
        },

        geocode: function() {

          function initialize() {
            var loc = {};
            var geocoder = geocoder || new google.maps.Geocoder();

            if (google.loader.ClientLocation) {

              $window.navigator.geolocation.getCurrentPosition(function(position) {

                ///use HTML5 Geolocation API
                ///if user allows to share location
                loc.lat = position.coords.latitude;
                loc.lng = position.coords.longitude;
                getGeocodeData();

              }, function(error) {

                ///use Google GeoCoder
                ///if user do not allows to share location
                loc.lat = google.loader.ClientLocation.latitude;
                loc.lng = google.loader.ClientLocation.longitude;
                getGeocodeData();

              });

            }

            function getGeocodeData() {
              var latlng = new google.maps.LatLng(loc.lat, loc.lng);
              geocoder.geocode({
                'latLng': latlng
              }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  var data = {
                    pincode: results[0]["address_components"][6],
                    country: results[0]["address_components"][5],
                    state: results[0]["address_components"][4],
                    city: results[0]["address_components"][3],
                    line1: results[0]["address_components"][2],
                    line2: results[0]["address_components"][1],
                    loc: loc
                  };

                };
              });
            }

          }

          google.load("maps", "3.x", {
            other_params: "sensor=false",
            callback: initialize
          });

        }
      }
    }
  ])
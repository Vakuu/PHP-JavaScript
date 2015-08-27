angular.module('slamdunk')
  .factory('courts_factory', ['$http', 'api_url', 'token', 'user',
    function($http, api_url, token, user) {
      return {

        //register court
        register: function(data) {
          //return $http.post(api_url + "/courts", data);
          var court = {
            court: data
          };
          return $http.post(api_url + "/courtswoi?access_token=" + token.get, court);
        },

        //updates court with the given id
        update: function() {
          //arguments[0] data
          //arguments[1] id
          //arguments[2] callback method
          var id = arguments[0]._id;
          var params = arguments[0];
          var obj = {
            "court": {
              "name": params.name,
              "ctype": params.ctype,
              "hheight": params.hheight,
              "lines": params.lines,
              "num_hoops": params.num_hoops,
              "surface": params.surface,
              "loc": params.loc,
              "address": {
                "country": params.address.country,
                "state": params.address.state,
                "city": params.address.city,
                "zip": params.address.zip,
                "street": params.address.street
              }
            }
          };

          return $http.put(api_url + '/courts/' + id + "\?access_token=" + token.get, obj);
        },

        //delete court with given id
        delete: function() {
          return $http.delete(api_url + '/courts/' + arguments[0]);
        },

        //get location of current user and generate list
        nearbyCourts: function(location) {
          //set default radius 50km
          var radius = 50;
          //http://sdapi.herokuapp.com/courts/loc/:long/:lat/:radius
          var url = [];
          url.push(api_url + '/courts/loc');
          url.push(location.lng);
          url.push(location.lat);
          url.push(radius + '?access_token=' + token.get);

          return $http.get(url.join('/'));
        },

        //returns array with courts.
        list: function() {
          //http://sdapi.herokuapp.com/courts/:perPage/:page
          return $http.get(api_url + "/courts/" + arguments[0] + "/" + arguments[1] + "\?access_token=" + token.get);
        },

        listDetails: function(a, b, cb) {
          $http
            .get(api_url + "/courts/" + arguments[0] + "/" + arguments[1] + "\?access_token=" + token.get)
            .success(function(data) {
              cb(data);
            })
            .error(function() {
              return;
            });
        },

        ///returns court with the given id
        get: function() {
          ///courts/:id 
          ///
          return $http.get(api_url + '/courts/' + arguments[0] + "\?access_token=" + token.get + "&nestuser=true");
        },

        //get SDN recommended courts
        sdnCourts: function() {
          return $http.get(api_url + "/court/sdncourts?access_token=" + token.get);
        },

        //get latest courts
        lastRegistered: function() {
          return $http.get(api_url + "/court/f/lastreg\?access_token=" + token.get);
        },

        getCitiesFromCountry: function(c) {
          return $http.post(api_url + "/court/c/filter\?access_token=" + token.get, {
            country: c
          });
        },

        //returns court count (indoor,outdoor,active indoor,active outdoor )
        getCourtCount: function(c) {
          //params country, city ( optional )
          return $http.post(api_url + "/court/f/filter\?access_token=" + token.get, c);
        },

        filter: function(c) {
          ///court/filter
          ///params - country,city,type,hheight ( can be omitted ) 
          ///-returns courts according the search criteria
          return $http.post(api_url + "/court/filter/10/1\?access_token=" + token.get, c);
        },

        showup: function(c) {
          /// /courts/attend
          /// { :cid , :uid }
          return $http.post(api_url + "/courts/attend\?access_token=" + token.get, c);
        },

        noshow: function(c) {
          ////courts/noattend'
          return $http.post(api_url + "/courts/noattend\?access_token=" + token.get, c);
        }

      };
    }
  ]);
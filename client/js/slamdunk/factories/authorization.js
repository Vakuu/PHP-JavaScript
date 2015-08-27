angular.module('slamdunk')
  .factory('authorization', ['$http', 'api_url', 'token', '$location', '$window',
    function($http, api_url, token, $location, $window) {
    'use strict';
    return {
      login: function(credentials) {
        return $http.post(api_url + '/auth\?sc=false', credentials);
      },

      //logout
      logout: function() {
        token.remove();
        $location.path('/login');
        //return $http.get(api_url + '/logout');
      },

      //new user registration
      registration: function(userinfo) {
        return $http.post(api_url + '/users\?sc=false', userinfo);
      },

      //if user forgets password
      forgetPassword: function(email) {

      },

      checkUnique: function(email) {

      }
    };
  }])
  .factory('simple', function() {
    return {
      name: "hari"
    }
  });
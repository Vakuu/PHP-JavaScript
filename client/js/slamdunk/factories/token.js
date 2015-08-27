'use strict';
angular.module('slamdunk')
  .factory('token', ['$cookieStore',
    function($cookieStore) {
      return {
        get: $cookieStore.get('access_token'),
        set: function(access_token) {
          $cookieStore.put('access_token', access_token);
        },
        remove: function() {
          $cookieStore.remove('access_token');
        },
        isSet: function() {
          if ($cookieStore.get('access_token') && $cookieStore.get('access_token') != "") {
            return true;
          } else {
            return false;
          }
        }
      }
    }
  ]);
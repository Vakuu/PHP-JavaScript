angular.module('slamdunk')
  .service('auth', ['$http', '$rootScope', '$cookieStore', '$location',
    function($http, $rootScope, $cookieStore, $location) {
      return {
        isLoggedIn: function() {
          if ($location.path() === "/login") {
            return false;
          } else {
            return true;
          }
        },
        login: function(user, success, error) {

        },
        logout: function(success, error) {

        }
      }
    }
  ]);
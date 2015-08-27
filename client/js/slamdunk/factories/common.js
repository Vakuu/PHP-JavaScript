'use strict';

angular.module('slamdunk')
  .factory('httpInterceptor', ['$q', '$window', '$location', '$rootScope', '$injector',
    function httpInterceptor($q, $window, $location, $rootScope, $injector) {
      'use strict';

      return function(promise) {
        var success = function(response) {
          return response;
        };
        var error = function(response) {
          //if server returns 401 status code that return to login page
          //401 (unauthorized)
          if (response.status == 401) {
            $location.url('/login');
          }
          return $q.reject(response);
        };
        //$rootScope.$broadcast('loading', true);
        return promise.then(success, error);
      };
    }
  ])
  .factory('api', ['$http', '$cookies',
    function($http, $cookies) {
      return {
        init: function(token) {
          //$http.defaults.headers.common['X-Access-Token'] = token || $cookies.token;
        }
      };
    }
  ]);

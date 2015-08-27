angular.module('slamdunk')

.factory('loader', ['$http', 'api_url', 'token', 'user', '$rootScope',
  function($http, api_url, token, user, $rootScope) {
    return {
      show: function() {
        $rootScope.$broadcast('loading', true);
      },
      hide: function() {
        $rootScope.$broadcast('loading', false);
      }
    }
  }
]);
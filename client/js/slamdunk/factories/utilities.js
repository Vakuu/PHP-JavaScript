angular.module('slamdunk')
  .factory('country', ['$http', 'token', 'api_url',
    function($http, token, api_url) {
      return {
        list: function() {
          return $http.get(api_url + "/countries?access_token=" + token.get);
        }
        
      }
    }
  ]);
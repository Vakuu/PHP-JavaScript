angular.module('slamdunk')
  .factory('friends', ['$http', 'api_url', 'token',
    function($http, api_url, token) {
      return {
        pending: function() {

        },
        send: function(data) {
          //PARAM: uid and fuid
          return $http.post(api_url + "/friends/request?access_token=" + token.get, data);  
        },
        accept: function() {
          //PARAM: fuid
          return $http.post(api_url + "/friends/accept?access_token=" + token.get, data);
        },
        block: function() {

        },
        suggested: function() {
          return $http.get(api_url + "/users/friends" + toke.get);
        }
      }
    }
  ]);
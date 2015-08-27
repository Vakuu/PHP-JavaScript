angular.module('slamdunk')

.factory('sdnProcess', ['$rootScope',
  function($rootScope) {
    return {
      show: function(msg) {
        $rootScope.$broadcast('processDis', true);
        $rootScope.$broadcast('processMsg', msg);
      },
      hide: function() {
        $rootScope.$broadcast('processMsg', '');
        $rootScope.$broadcast('processDis', false);
      }
    }
  }
]);
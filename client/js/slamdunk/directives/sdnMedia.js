'use strict';
angular.module('slamdunk')
  .directive('sdnMedia', ['sdnVersion', 'user',
    function(sdnVersion, user) {
      return {
        restrict: 'A',
        replace: true,
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-media.html",
        link: function(scope, element, attrs) {
          scope.shareFB = function() {

          };
        }
      };
    }
  ]);
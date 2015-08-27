'use strict';
angular.module('slamdunk')
  .directive('sdnScrollBar', ['sdnVersion', 'user',
    function(sdnVersion, user) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {
          $(element).perfectScrollbar();
        }
      };
    }
  ]);
'use strict';
angular.module('slamdunk')
  .directive('sdnTwitterSharing', ['sharing',
    function(sharing) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {


        }

      };

    }
  ]);
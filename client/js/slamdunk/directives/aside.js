angular.module('slamdunk')
  .directive('snAside', ['$window',
    function($window) {
      'use strict';
      return {
        strict: "A",
        link: function(scope, element, attrs, ctrl) {

          scope.openVisible = false;
          scope.closeVisible = true;

          scope.asideVisibility = function(status) {
            var leftPosition = 0;
            if (status == "open") {
              scope.openVisible = false;
              scope.closeVisible = true;
              leftPosition = 0;
            } else {
              scope.closeVisible = false;
              scope.openVisible = true;
              leftPosition = -parseInt($(element).css('width'), 10);
            }
            element.css('left', leftPosition + 'px');
          };

        }
      };
    }
  ])
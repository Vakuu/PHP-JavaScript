angular.module('slamdunk')
  .directive('snStickyHeader', ['$window',
    function($window) {
      'use strict';

      return {
        strict: "A",
        link: function(scope, element, attrs, ctrl) {

          function setClass() {
            if ($window.pageYOffset >= 80) {
              element.addClass('sticky-header');
              element.removeClass('non-sticky-header');
            } else {
              element.removeClass('sticky-header');
              element.addClass('non-sticky-header');
            }
          }
          setClass();
          angular.element($window).bind('scroll', function() {
            setClass();
          });
        }
      };
    }
  ]);
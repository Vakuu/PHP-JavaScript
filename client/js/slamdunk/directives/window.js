angular.module('slamdunk')
  .directive('snWindow', ['$window',
    function($window) {
      'use strict';

      var setHeight = function(element, minusHeight) {
        element.css('height', ($window.innerHeight - minusHeight) + "px");
      };

      return {
        strict: "A",
        link: function(scope, element, attrs, ctrl) {
          var minusHeight = Number(attrs.snWindow);
          setHeight(element, minusHeight);
          $(window).on("resize", function() {
            setHeight(element, minusHeight);
          });
        }
      };
    }
  ]);
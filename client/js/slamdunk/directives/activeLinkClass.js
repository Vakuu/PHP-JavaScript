angular.module('slamdunk')
  .directive('selectActiveLink', function() {
    'use strict';
    return {
      link: function(scope, element, attrs, ctrl) {

        var classname = attrs.activeLinkClass ? attrs.activeLinkClass : "active";

        globalClass.selectActiveSubNav({
          class: classname,
          element: element
        });

        scope.$on('$routeChangeSuccess', function(scope, next, current) {
          globalClass.selectActiveSubNav({
            class: classname,
            element: element
          });
        });
      }
    };
  });
'use strict';
angular.module('slamdunk')
  .directive('sdnTabChange', ['sharing',
    function(sharing) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {
          $(element).on('shown.bs.tab', 'a[data-toggle="tab"]', function() {
            scope[attrs.sdnTabChange]($(this).attr("id"));
          });
        }
      };

    }
  ]);
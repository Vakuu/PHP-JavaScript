'use strict';
angular.module('slamdunk')
  .directive('sdnModelClose', ['sharing',
    function(sharing) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {
          console.log(attrs, "model attrs");
          $('#' + attrs["id"]).on('hidden.bs.modal', function() {
            // do something…
            //alert(attrs.sdnModelClose);
            scope[attrs.sdnModelClose]();
          })
        }
      };

    }
  ]);
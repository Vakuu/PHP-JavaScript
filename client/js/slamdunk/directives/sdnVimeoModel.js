'use strict';
angular.module('slamdunk')
  .directive('sdnVimeoModel', ['sharing',
    function(sharing) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {

          var iframe = document.getElementById('video');

          var player = $f(iframe);

          $('#' + attrs["id"]).on('hidden.bs.modal', function() {
            player.api('pause');
          });
        }
      };

    }
  ]);
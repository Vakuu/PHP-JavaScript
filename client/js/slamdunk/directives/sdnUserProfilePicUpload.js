'use strict';
angular.module('slamdunk')
  .directive('sdnUserProfilePicUpload', ['sdnVersion', 'user',
    function(sdnVersion, user) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {
          element.bind('click', function() {
            $('#modal-upload-pro-pic').modal('show');
          });
        }
      };
    }
  ]);
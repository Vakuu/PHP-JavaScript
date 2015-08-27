'use strict';
angular.module('slamdunk')
  .directive('sdnFacebookSharing', ['sharing',
    function(sharing) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {

          var _caption = attrs["caption"],
            _description = attrs["description"],
            _name = attrs["name"],
            _pic = attrs["pic"],
            _link = attrs["link"];

          element.bind('click', function() {
            sharing.facebook({
              name: _name,
              caption: _caption,
              description: _description,
              link: _link,
              picture: _pic
            });
          });

        }

      };

    }
  ]);
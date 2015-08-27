angular.module('slamdunk')
  .directive('sdnWall', ['$window', '$compile', 'sdnVersion', 'networkService', 'sharing',
    function($window, $compile, sdnVersion, networkService, sharing) {
      'use strict';

      return {
        restrict: "E",
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-wall.html",
        link: function(scope, element, attrs, ctrl) {

          //set limit of undifined limit attribute
          if (attrs.limit && attrs.limit != '') {
            scope.limitPost = attrs.limit;
          } else {
            scope.limitPost = 50;
          };

          //fetch dummy post data

          //hide show comments
          scope.toggleComments = function() {
            if (this.post.showComments) {
              this.post.showComments = false;
            } else {
              this.post.showComments = true;
            }
          };

          scope.shareFacebook = function(_picture, _caption) {
            sharing.facebook({
              picture: _picture,
              caption: _caption,
              link: $window.location.href,
              redirect_uri: $window.location.href
            });
          };

          scope.shareTwitter = function(_caption) {
            sharing.twitter({
              caption: _caption,
              link: $window.location.href,
            });
          };

        }

      };

    }
  ]);
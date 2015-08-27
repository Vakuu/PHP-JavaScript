'use strict';
angular.module('slamdunk')
  .directive('searchuser', ['sdnVersion', 'user', 'loader',
    function(sdnVersion, user, loader) {
      return {
        restrict: 'E',
        replace: false,
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-usersearch.html",
        link: function(scope, element, attrs) {


          scope.name = scope.name || "";

          scope.close = function() {
            scope.name = "";
          };

          scope.findUser = function() {
            if (scope.name != "") {
              //loader.show();
              scope.loading_user = true;
              user.get({
                name: scope.name
              })
                .success(function(data) {
                  scope.loading_user = false;
                  scope.err = "";
                  scope.results = data;
                })
                .error(function(err) {
                  scope.err = err;
                  scope.loading_user = false;
                  scope.results = [];
                });
            } else {
              //loader.hide();
              scope.loading_user = false;
              scope.results = [];
            }
          };
        }
      };
    }
  ]);
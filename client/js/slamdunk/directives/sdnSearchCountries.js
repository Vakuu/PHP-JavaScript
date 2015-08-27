'use strict';
angular.module('slamdunk')
  .directive('sdnSearchCountries', ['sdnVersion', 'user', 'geolocation',
    function(sdnVersion, user, geolocation) {
      return {
        restrict: 'E',
        replace: true,
        scope: {
          "name": "="
        },
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-search-countries.html",
        link: function(scope, element, attrs) {
          scope.name = scope.name || "";
          scope.$watch('name', function(v) {
            if (scope.name != "") {
              geolocation.searchCountries(scope.name)
                .success(function(data) {
                  scope.countries = data;
                })
                .error(function(err) {
                  scope.countries = [];
                });
            } else {
              scope.countries = [];
            }
          });
        }
      };
    }
  ]);
angular.module('slamdunk')
  .directive('sdnBadges', ['$window', '$compile', 'sdnVersion', 'networkService',
    function($window, $compile, sdnVersion, networkService) {
      'use strict';
      return {
        restrict: "E",
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-badges.html",
        link: function(scope, element, attrs, ctrl) {

        }
      };
    }
  ]);
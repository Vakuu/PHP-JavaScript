angular.module('slamdunk')
  .directive('sdnCalender', ['$window', '$compile', 'sdnVersion', 'networkService',
    function($window, $compile, sdnVersion, networkService) {
      'use strict';
      return {
        restrict: "E",
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-calender.html",
        link: function(scope, element, attrs, ctrl) {

        }
      };
    }
  ]);
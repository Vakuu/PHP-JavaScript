angular.module('slamdunk')
.directive('compareTo', function() {
  'use strict';

  return {
    require: 'ngModel',
    link: function (scope, element, attrs, ctrl) {
      var form = attrs.formName;
      var field = attrs.compareTo;

      ctrl.$parsers.unshift(function (viewValue, $scope) {
        var noMatch = viewValue != scope[form][field].$viewValue;
        ctrl.$setValidity('noMatch', !noMatch);
      });
    }
  };
});

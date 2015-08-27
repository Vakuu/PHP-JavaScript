angular.module('slamdunk')
  .directive('duplicate', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, elm, attrs, ctrl) {
        ctrl.$parsers.unshift(function(viewValue) {
          var duplicate = scope[attrs.duplicate];
          console.log(scope.duplicate);
          if (scope.duplicate.indexOf(viewValue) !== -1) {
            ctrl.$setValidity('duplicate', false);
            return undefined;
          } else {
            ctrl.$setValidity('duplicate', true);
            return viewValue;
          }
        });
      }
    };
  });
angular.module("ui.bootstrap.alert", [])

.controller('AlertController', ['$scope', '$attrs',
  function($scope, $attrs) {
    $scope.closeable = 'close' in $attrs;
  }
])
  .constant('sdnVersion', document.querySelector('html').getAttribute('data-app-version'))
  .directive('alert', ['sdnVersion',
    function(sdnVersion) {
      return {
        restrict: 'EA',
        controller: 'AlertController',
        templateUrl: sdnVersion + '/templates/directive-templates/alert.html',
        transclude: true,
        replace: true,
        scope: {
          type: '=',
          close: '&'
        }
      };
    }
  ]);
angular.module('slamdunk')
  .controller('NetworkCtrl', ['$scope', '$location', '$http', '$rootScope', 'user', 'sdnProcess',
    function($scope, $location, $http, $rootScope, user, sdnProcess) {
      'use strict';
      //sdnProcess.show("We are processing ... ...");
      $scope.ctrlName = 'NetworkCtrl';

      $scope.pro_finished = user.profileProgress($scope.activeUser);

      $scope.changeRoute = function() {
        $location.path("/test-route");
      };

    }
  ]);
angular.module('slamdunk')
  .controller('MyProfileCtrl', ['$scope', 'userInfo',
    function($scope, userInfo) {
      'use strict';

      $scope.ctrlName = 'MyProfileCtrl';

      $scope.init = function() {
        console.log(userInfo);
      };

      $scope.info = userInfo;
      //$scope.globalClass = globalClass;

      $scope.init();

    }
  ]);
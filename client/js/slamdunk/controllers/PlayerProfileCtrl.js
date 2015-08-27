angular.module('slamdunk')
  .controller('PlayerProfileCtrl', ['$scope', 'playerInfo', 'growl', 'friends', 'user', '$rootScope',
    function($scope, playerInfo, growl, friends, user, $rootScope) {
      'use strict';

      $scope.ctrlName = 'PlayerProfileCtrl';

      //
      $scope.info = playerInfo;
      //console.log($scope.info, "info");
      //console.log($rootScope.activeUser, "root scope active user");

      //connect with player
      $scope.connect = function() {
        $scope.pendding = true;
        friends.send({
          uid: $rootScope.activeUser._id,
          fuid: playerInfo._id
        }).success(function() {
          $scope.pendding = true;
          growl.addSuccessMessage("Friend request sent successfully!");
        }).error(function() {
          growl.addErrorMessage("Error while sending friend request, please try again later");
        })
      };

      //disconnect with player
      $scope.disconnect = function() {
        $scope.connected = false;
      };

      //bench profile
      $scope.benchProfile = function() {

      };



    }
  ]);
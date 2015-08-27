angular.module('slamdunk')
  .controller('PlayersCtrl', ['$scope', 'playersService',
    function($scope, playersService) {
      'use strict';

      $scope.ctrlName = 'PlayersCtrl';

      playersService.GetAllPlayers(function(data) {
        $scope.players = data;
      });

    }
  ]);
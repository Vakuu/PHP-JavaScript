angular.module('slamdunk')
  .controller('GamesCtrl', ['$scope', 'playersService',
    function($scope, playersService) {
      'use strict';

      $scope.ctrlName = 'GamesCtrl';

      playersService.GetAllPlayers(function(data) {
        $scope.players = data;
      });

    }
  ]);
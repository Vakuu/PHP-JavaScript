angular.module('slamdunk')
  .controller('TeamsCtrl', ['$scope', 'playersService', function($scope, playersService) {
  'use strict';

  $scope.ctrlName = 'TeamsCtrl';

  playersService.GetAllPlayers(function(data) {
    $scope.players = data;
  });

}]);
angular.module('slamdunk')
.controller('CourtProfileCtrl', ['$scope', 'courtInfo', 'user', '$window', 'sharing', 'courts_factory', 'loader',
  function($scope, courtInfo, user, $window, sharing, courts_factory, loader) {
    'use strict';

    $scope.info = courtInfo;

    $scope.court_url = $window.location.host + '/%23%/court-profile/' + $scope.info._id;

    $scope.activeUser = {};

    function defaultButtonVisiblity() {
      $scope.displayNoShow = false;
      $scope.displayShowUp = true;
      $scope.info.playersAttendingToday.forEach(function(v) {
        if (v._id == $scope.activeUser._id) {
          $scope.displayNoShow = true;
          $scope.displayShowUp = false;
        }
      })
    };

    user.activeUser(function(data) {
      $scope.activeUser = data;
      defaultButtonVisiblity();
    }, function(err) {});

    //facebook share
    $scope.shareCourtFB = function(_picture, _caption) {
      sharing.facebook({
        name: $scope.info.name,
        caption: 'Slamdunk Network',
        description: $scope.info.description,
        link: $window.location.href,
        picture: $scope.info.mainImage ? $scope.info.mainImage.image_large_url : 'http://www.google.com'
      })
    };

    //twiiter share
    $scope.shareCourtTwitter = function(_caption) {
      sharing.twitter({
        caption: $scope.info.name,
        link: $window.location.href,
      });
    };

    $scope.showup = function() {
      loader.show();
      courts_factory.showup({
        cid: $scope.info._id,
        uid: $scope.activeUser._id
      }).success(function(data) {
        loader.hide();
        $scope.reloadData();
        $scope.displayNoShow = true;
        $scope.displayShowUp = false;

      }).error(function(errr) {
        console.error(errr);
      })
    };

    $scope.noshow = function() {
      loader.show();
      courts_factory.noshow({
        cid: $scope.info._id,
        uid: $scope.activeUser._id
      }).success(function(data) {
        $scope.displayNoShow = false;
        $scope.displayShowUp = true;
        $scope.reloadData();
        loader.hide();
      }).error(function(errr) {
        console.error(errr);
        loader.hide();
      });
    };

    $scope.reloadData = function() {
      courts_factory.get($scope.info._id).success(function(message) {
        loader.hide();
        $scope.info = message;
      }).error(function(message) {
        loader.hide();
      });
    };

  }
]);
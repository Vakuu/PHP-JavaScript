angular.module('slamdunk')
  .controller('MainCtrl', ['$cookieStore', 'token', 'loader', '$cookies', 'api', '$scope', '$location', 'api_url', '$http', '$rootScope', 'authorization', '$window', 'user', 'fb_app_id', '$timeout', 'growl', 'PubNub',
    function($cookieStore, token, loader, $cookies, api, $scope, $location, api_url, $http, $rootScope, authorization, $window, user, fb_app_id, $timeout, growl, PubNub) {
      'use strict';

      $scope.ctrlName = 'MainCtrl';

      $scope.init = function() {};
      $scope.visitor = {};

      $scope.activeUser = {};
      $scope.fb_app_id = fb_app_id;
      // user.activeUser().success(function(data) {
      //   $scope.activeUser = data;
      // }).error(function(err) {

      // });
      $scope.notification = [];
      user.activeUser(function(data) {
        $scope.activeUser = data;
        // - 
      }, function(err) {}, true);

      $scope.alerts = [
        // {
        //   type: 'danger',
        //   msg: 'Oh snap! Change a few things up and try submitting again.'
        // }
      ];

      if ($rootScope.activeUser) {

        PubNub.ngSubscribe({
          channel: $rootScope.activeUser._id
        });

        $scope.$on(PubNub.ngMsgEv($rootScope.activeUser._id), function(event, payload) {
          // payload contains message, channel, env...
          console.log('got a message event:', payload);
          alert("you got pun nub msg");
          $scope.notification.push(payload);
        });
      }



      $scope.addAlert = function() {
        $scope.alerts.push({
          msg: "Another alert!"
        });
      };

      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

      //login
      $scope.login = function() {
        loader.show();
        //successful login callback
        var success = function(res) {
          //this method will put header in each http header
          api.init(res.token);
          token.set(res.token);
          loader.hide();
          $window.location.href = "/";
        };

        //error in login callback
        var error = function(err) {
          loader.hide();
          $scope.error = err.error;
          // TODO: apply user notification here..
        };

        //login factory method
        authorization.login($scope.visitor).success(success).error(error);
      };

      //register new user
      $scope.register = function() {};

      //logout
      $scope.logout = function() {
        authorization.logout();
      };

      $scope.$on('$routeChangeStart', function(scope, next, current) {

        loader.show();

        //navigation is based on this model variable
        if (token.isSet()) {
          $scope.isLoggedIn = true;
        } else {
          $scope.isLoggedIn = false;
          authorization.logout();
        }

        if ($location.$$path == "/login") {
          $scope.isLoggedIn = false;
          authorization.logout();
        }
      });

      $scope.$on('$routeChangeSuccess', function() {
        loader.hide();
        $scope.handle = $location.$$path.replace('/', '_');
      });

      $scope.$on('loading', function(scope, next, current) {
        $scope.loading = next;
      });

      $scope.$on('processDis', function(scope, next, current) {
        $scope.processDis = next;
      });

      $scope.$on('processMsg', function(scope, next, current) {
        $scope.processMsg = next;
      });



      // $scope.channels = PubNub.ngListChannels();

      // $scope.$watch('channels', function() {
      //   $scope.userData = PubNub.ngPresenceData("hari");
      //   console.log($scope.userData);
      // })


    }

  ]);
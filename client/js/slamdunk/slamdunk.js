(function() {
  'use strict';

  angular.module('slamdunk', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngTable',
    'ui.bootstrap.datetimepicker',
    'ui.map',
    'ui.bootstrap.pagination',
    'ui.bootstrap.alert',
    'angularFileUpload',
    'angular-growl',
    'pubnub.angular.service'
  ])
    .constant('sdnVersion', document.querySelector('html').getAttribute('data-app-version'))
    .constant('api_url', 'http://sdapi.herokuapp.com')
    //.constant('api_url', 'http://localhost:8080')
    .constant('fb_app_id', 150251821812646)
    .config(['$routeProvider', '$locationProvider', 'sdnVersion', '$httpProvider', 'growlProvider', function($routeProvider, $locationProvider, sdnVersion, $httpProvider, growlProvider) {
      //$locationProvider.html5Mode(true);one son
      $httpProvider.responseInterceptors.push('httpInterceptor');
      growlProvider.globalTimeToLive(3000);
      $routeProvider
        
      .when('/', {
          templateUrl: '/' + sdnVersion + '/templates/hoopmap.html',
          controller: 'HoopmapCtrl'
        })

      .when('/login', {
          templateUrl: '/' + sdnVersion + '/templates/login.html',
          controller: 'LoginCtrl'
        })

      .when('/test-route', {
          templateUrl: '/' + sdnVersion + '/templates/test.html',
          controller: 'TestCtrl'
        })

      .when('/hoopmap', {
          templateUrl: '/' + sdnVersion + '/templates/hoopmap.html',
          controller: 'HoopmapCtrl'
        })

      .when('/network', {
          templateUrl: '/' + sdnVersion + '/templates/network.html',
          controller: 'NetworkCtrl'
        })

      .when('/player-profile/:pid', {
          templateUrl: '/' + sdnVersion + '/templates/player-profile.html',
          controller: 'PlayerProfileCtrl',
          resolve: {
            playerInfo: ['$q', 'user', 'loader', '$route', '$location', function($q, user, loader, $route, $location) {
              loader.show();
              var deferred = $q.defer(),
                pid = $route.current.params.pid;
              user.getById(pid).success(function(message) {
                loader.hide();
                deferred.resolve(message);
              }).error(function(message) {
                loader.hide();
                deferred.reject(message);
                $location.path('#/400');
              });
              return deferred.promise;
            }]
          }
        })

      .when('/court-profile/:cid', {
          templateUrl: '/' + sdnVersion + '/templates/court-profile.html',
          controller: 'CourtProfileCtrl',
          resolve: {
            courtInfo: ['$q', 'courts_factory', 'loader', '$route', '$location', function($q, courts_factory, loader, $route, $location) {
              loader.show();
              var deferred = $q.defer(),
                cid = $route.current.params.cid;
              courts_factory.get(cid).success(function(message) {
                loader.hide();
                deferred.resolve(message);
              }).error(function(message) {
                loader.hide();
                deferred.reject(message);
                $location.path('#/400');
              });
              return deferred.promise;
            }]
          }
        })

      .when('/edit-court/:cid', {
          templateUrl: '/' + sdnVersion + '/templates/edit-court.html',
          controller: 'EditCourtCtrl',
          resolve: {
            courtInfo: ['$q', 'courts_factory', 'loader', '$route', '$location', '$rootScope', 'user', function($q, courts_factory, loader, $route, $location, $rootScope, user) {
              loader.show();
              var deferred = $q.defer(),
                cid = $route.current.params.cid;
              courts_factory.get(cid).success(function(message) {
                if(!$rootScope.activeUser) {
                  user.activeUser(function(res) {
                    loader.hide();
                    if (res._id != message.userId._id) {
                      deferred.reject(message);
                      $location.path('#/400');
                    }
                    deferred.resolve(message);
                  }, function(message) {
                    deferred.reject(message);
                  });
                } else {
                  loader.hide();
                  if ($rootScope.activeUser._id != message.userId._id) {
                    deferred.reject(message);
                    $location.path('#/400');
                  }
                  deferred.resolve(message);
                }
              }).error(function(message) {
                loader.hide();
                deferred.reject(message);
                $location.path('#/400');
              });
              return deferred.promise;
            }]
          }
        })

      .when('/my-profile', {
          templateUrl: '/' + sdnVersion + '/templates/my-profile.html',
          controller: 'MyProfileCtrl',
          resolve: {
            userInfo: ['$q', 'user', 'loader', function($q, user, loader) {
              loader.show();
              var deferred = $q.defer();
              user.activeUser(function(message) {
                loader.hide();
                deferred.resolve(message);
              }, function(message) {
                deferred.reject(message);
              });
              return deferred.promise;
            }]
          }
        })

      .when('/auth/:token', {
          resolve: {
            userInfo: ['$q', 'user', 'loader', '$route', 'token', '$window', function($q, user, loader, $route, token, $window) {
              loader.show();
              var deferred = $q.defer(),
                accessed_token = $route.current.params.token;
              token.set(accessed_token);
           
              $window.location.href = "";
              return deferred.promise;
            }]
          }
        })

      .when('/team-profile', {
          templateUrl: '/' + sdnVersion + '/templates/team-profile.html',
          controller: 'TeamProfileCtrl'
        })

      .when('/players', {
          templateUrl: '/' + sdnVersion + '/templates/players.html',
          controller: 'PlayersCtrl'
        })

      .when('/teams', {
          templateUrl: '/' + sdnVersion + '/templates/teams.html',
          controller: 'TeamsCtrl'
        })

      .when('/courts', {
          templateUrl: '/' + sdnVersion + '/templates/courts.html',
          controller: 'CourtsCtrl'
        })

      .when('/edit-profile', {
          templateUrl: '/' + sdnVersion + '/templates/edit-profile.html',
          controller: 'EditProfileCtrl',
          resolve: {
            userInfo: ['$q', 'user', function($q, user) {
              var deferred = $q.defer();
              user.activeUser(function(message) {
                deferred.resolve(message);
              }, function(message) {
                deferred.reject(message);
              });
              return deferred.promise;
            }]
          }
        })

      .when('/games', {
          templateUrl: '/' + sdnVersion + '/templates/games.html',
          controller: 'GamesCtrl'
        })

      .when('/404', {
          templateUrl: '/' + sdnVersion + '/templates/404.html',
          controller: 'NotFoundCtrl'
        })

      .otherwise({
          redirectTo: '/404'
        });
    }])

  // Whitelist of allowed hosts for AJAX requests
  .config(['$sceDelegateProvider', function($sceDelegateProvider) {
    $sceDelegateProvider.resourceUrlWhitelist([
      'self',
      'http://localhost/**',
      'http://onsideanalyst.herokuapp.com/**'
    ]);
  }])

  .run(['$rootScope', '$location', 'sdnVersion', '$http', '$timeout', 'user', '$route', '$templateCache', 'PubNub', '$q', function($rootScope, $location, sdnVersion, $http, $timeout, user, $route, $templateCache, PubNub, $q) {

    $rootScope.$safeApply = function($scope, fn) {
      fn = fn || function() {};

      if ($scope.$$phase) {
        fn();
      } else {
        $scope.$apply(fn);
      }

    };

    $rootScope.isDefined = function(obj) {
      if (obj === undefined || obj === "" || obj === null) {
        return false;
      } else {
        return true;
      }

    };

    //TODO: PUBNUB NOTIFICATION SERVICE INIT FUNCTION
    PubNub.init({
      publish_key: 'pub-c-b45460e2-8b62-4459-b24c-7578f08f1caf',
      subscribe_key: 'sub-c-96696c58-9d4a-11e3-a759-02ee2ddab7fe'
      //uuid: 'an_optional_user_uuid'
    });

    // user.activeUser().success(function(u) {
    //   $rootScope.activeUser = u;
    // }).error(function() {

    // });
  
    user.activeUser(function(u) {
      $rootScope.activeUser = u;
    }, function(err) {

    });


    //always automatically clear the cache whenever the ng-view content changes:
    $rootScope.$on('$viewContentLoaded', function() {
      $templateCache.removeAll();
    });

   
  }]);

})();
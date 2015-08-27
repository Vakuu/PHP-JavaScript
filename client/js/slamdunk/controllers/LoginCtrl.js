angular.module('slamdunk')
  .controller('LoginCtrl', ['$scope', '$http', '$rootScope', '$location', 'auth', 'user', 'api', 'token', '$window', 'month', 'loader',
    function($scope, $http, $rootScope, $location, auth, user, api, token, $window, month, loader) {
      'use strict';

      $scope.ctrlName = 'LoginCtrl';
      $scope.years = [];
      $scope.user_dob = {};
      $scope.user = {};

      $scope.login = function() {
        loader.show();
        $http.post('/login', $scope.user)
          .success(function(data, status, headers, config) {
            $rootScope.currentUser = data;
            loader.hide();
            $location.path('/');
          })
          .error(function(data, status, headers, config) {
            console.log(data);
            console.log(status);
            loader.hide();
            $scope.errorMessage = (data && data.error) || 'Invalid credentials';
          });
      };

      $scope.months = month;

      $scope.fillYears = function() {
        var from = new Date().getFullYear() - 100;
        var to = new Date().getFullYear();
        for (var i = 0; i < 100; i++) {
          $scope.years.push(++from);
        };
      };

      //fill years in dropdown
      $scope.fillYears();

      //fill days using date and month
      $scope.fillDateData = function() {

        var month;
        $scope.days = [];

        if ($scope.user_dob.month && $scope.user_dob.year) {
          month = $scope.user_dob.month.value;
          for (var i = 0; i < new Date($scope.user_dob.year, month, 0).getDate(); i++) {
            $scope.days.push(i + 1);
          }
          $scope.calculageAge();
        };


      };

      $scope.calculageAge = function() {

        if (!$scope.user_dob.day) return;

        $scope.user.dob = $scope.user_dob.year + '-' + $scope.user_dob.month.value + '-' + $scope.user_dob.day;

        var age = globalClass.getAge($scope.user.dob)

        if (age < 18) {
          $scope.frmSignup.$setValidity('dob', false);
          setSignUpFormError("Your age must be above 18 year");
        } else {
          $scope.frmSignup.$setValidity('dob', true);
        }

      };

      $scope.comparePassword = function() {
        if ($scope.user.password && $scope.user.repassword) {

          if ($scope.user.password != $scope.user.repassword) {
            $scope.frmSignup.$setValidity('password', false);
            setSignUpFormError("Password doesn't match");
          } else {
            $scope.frmSignup.$setValidity('password', true);
          }
        }
      };

      $scope.compareEmail = function() {
        if ($scope.user.email && $scope.user.reemail) {

          if ($scope.user.email != $scope.user.reemail) {
            $scope.frmSignup.reemail.$setValidity('reemail', false);
          } else {
            $scope.frmSignup.reemail.$setValidity('reemail', true);
          }

        }
      };

      $scope.test = function() {
        $scope.frmSignup.email.$setValidity('email', false);
      };

      $scope.CheckEmailValidity = function() {
        console.log($scope.frmSignup);
        if ($scope.user.email) {
          user.isExist($scope.user.email).success(function(d) {

            if (d.exists)
              $scope.frmSignup.email.$setValidity('email', false);

          }).error(function() {

          });
        }

      };

      function setSignUpFormError(message) {
        $scope.frmSignup.error = true;
        $scope.frmSignup.message = message;
        if (!message) {
          $scope.frmSignup.error = false;
          $scope.frmSignup.message = "";
        }
      };

      $scope.getSetLname = function() {
        $scope.user.fname = $scope.user.name.split(' ')[0];
        $scope.user.lname = "";

        for (var i = 1; i < $scope.user.name.split(' ').length; i++) {
          $scope.user.lname += $scope.user.name.split(' ')[i] + " ";
        }

        if (!$scope.user.lname || $scope.user.lname == '') {
          $scope.frmSignup.$setValidity('name', false);
        } else {
          $scope.frmSignup.$setValidity('name', true);
        }
      }

      $scope.create = function() {

        loader.show();

        //skips email conformation
        var objUser = {};
        objUser.user = $scope.user;
        objUser.sc = true;

        user.create(objUser).success(function(res) {
          loader.hide();
          api.init(res.token);
          token.set(res.token);
          $window.location.href = "/";

        }).error(function(err) {
          console.log(err);
          loader.hide();
          $scope.frmSignup.error = true;
          $scope.frmSignup.message = "Error";
          $scope.alerts.push({
            type: "danger",
            msg: "Error while processing, Please try again later"
          })
        });
      };

      $scope.fillDateData();

      $scope.CloseVideoModel = function() {
      };

      $scope.changeURL = function() {
        
      };

    }
  ]);
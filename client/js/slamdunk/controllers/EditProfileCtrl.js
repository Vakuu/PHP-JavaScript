'use strict';
angular.module('slamdunk')
  .controller('EditProfileCtrl', ['$scope', 'playersService', 'userInfo', 'month', 'user', '$timeout', '$compile', '$location', 'growl', 'country',
    function($scope, playersService, userInfo, month, user, $timeout, $compile, $location, growl, country) {
      'use strict';

      $scope.ctrlName = 'EditProfileCtrl';
      $scope.userInfo = userInfo;

      //country list
      country.list().success(function(data) {
        $scope.countries = data.Countries;

        //TODO : Select Country and load all the courts of that counrty


      }).error(function() {
        growl.addErrorMessage("Error while loading country list");
      });


      //initialze address array
      if (!$scope.userInfo.address) {
        $scope.userInfo.address = {
          country: "",
          state: "",
          city: "",
          zip: "",
          street: ""
        };
      };

      $scope.years = [];
      $scope.months = month;
      $scope.user_dob = {};

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

        $scope.userInfo.dob = $scope.user_dob.year + '-' + $scope.user_dob.month.value + '-' + $scope.user_dob.day;

        //alert($scope.userInfo.dob);

        var age = globalClass.getAge($scope.userInfo.dob)

        if (age < 18) {
          //$scope.frmSignup.$setValidity('dob', false);
          //setSignUpFormError("Your age must be above 18 year");
        } else {
          //$scope.frmSignup.$setValidity('dob', true);
        }
      };

      $scope.editUserProfile = function() {
        
        var param = $scope.userInfo;
        
        user.update(param).success(function(res) {
          growl.addSuccessMessage("Your profile is updated");
          $location.path( "/my-profile" );
        }).error(function() {
          growl.addErrorMessage("Error while updating user");
        });
      };

      $scope.imageUploadStart = function() {
        $scope.imgLoading = true;
      };

      $scope.callback = function(url) {
        $scope.userInfo.photo.image_medium_url = url;
        $scope.imgLoading = false;
      };

      //load initial value of dob
      var dob = new Date($scope.userInfo.dob);
      $scope.user_dob.year = dob.getFullYear();
      $scope.user_dob.month = month[dob.getMonth()];
      $scope.user_dob.day = dob.getDate();
      $scope.fillDateData();

      $scope.editProfilePic = function() {};
    }
  ]);
angular.module('slamdunk')
  .controller('CourtsCtrl', ['$scope', 'playersService', 'courts_factory', 'loader',
    function($scope, playersService, courts_factory, loader) {
      'use strict';

      $scope.ctrlName = 'CourtsCtrl';
      $scope.total_indoor = $scope.total_street = $scope.total_active = "--";
      //loader.show();
      // courts_factory.listDetails(50, 1, function(data) {
      //   $scope.courts = data.courts;
      //   $scope.total = data.total;
      //   console.log(data);
      //   loader.hide();
      // });

      $scope.totalItems = 64;
      $scope.currentPage = 4;

      $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
      };

      $scope.$watch('currentPage', function() {
      });

      $scope.pageChanged = function() {
        console.log('Page changed to: ' + $scope.currentPage);
      };

      $scope.maxSize = 5;
      $scope.bigTotalItems = 175;
      $scope.bigCurrentPage = 1;


      //Court Filter
      $scope.filter = {};
      $scope.CourtFilter = function() {
        loader.show();
        var filteredCourts = [];

        changeCourtCount();

        // var obj = {
        //   city: $scope.filter.city,
        //   country: $scope.filter.country
        // };
        var obj = {};
        if ($scope.filter.city)
          obj.city = $scope.filter.city;

        if ($scope.filter.county)
          obj.country = $scope.filter.country;

        if ($scope.filter.ctype)
          obj.ctype = $scope.filter.ctype;

        console.log($scope.filter);

        courts_factory.filter($scope.filter).success(function(c) {
          ////
          filteredCourts = c;
          $scope.courts = c;
          loader.hide();
          ////
        }).error(function(err) {

        });
      };
      $scope.CourtFilter();
      ///loading city on country change
      $scope.filter = {
        cities: [],
        ctype: {}
      };

      ///
      $scope.countryChange = function() {

        if ($scope.filter.country && $scope.filter.country != "") {

          $scope.loadCities = true;
          courts_factory.getCitiesFromCountry($scope.filter.country).success(function(d) {
            $scope.loadCities = false;
            $scope.filter.cities = d;
            $scope.filter.city = "";
            $scope.CourtFilter();

          }).error(function(err) {
            $scope.loadCities = false;
          });
        } else {
          $scope.filter.cities = [];
          $scope.filter.city = "";
          $scope.CourtFilter();
        }
      };

      changeCourtCount();

      function changeCourtCount() {
        $scope.total_indoor = $scope.total_street = $scope.total_active = "--";

        courts_factory.getCourtCount($scope.filter).success(function(result) {

          angular.forEach(result, function(r) {
            if (r.ctype == "indoor") {
              $scope.total_indoor = r.total_courts;
            } else if (r.ctype == "street") {
              $scope.total_street = r.total_courts;
            } else if (r.ctype == "active_court") {
              $scope.total_active = r.total_courts;
            }
          });

        }).error(function(err) {

        })
      };
    }
  ]);
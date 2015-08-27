angular.module('slamdunk')
  .directive('sdnTeamRating', ['$window', '$compile', 'sdnVersion', 'networkService',
    function($window, $compile, sdnVersion, networkService) {
      'use strict';
      return {
        restrict: "E",
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-team-rating.html",
        link: function(scope, element, attrs, ctrl) {

          scope.editSkills = true;

          $('.sdn-progressbar').click(function(e) {

            var posX = $(this).offset().left,
              ratting = $(this).find('div.sdn-ratting'),
              posY = $(this).offset().top,
              clickPosition = (e.pageX - posX),
              perc = (100) - ($(this).width() - clickPosition) * 100 / $(this).width();


            if (ratting.width() >= clickPosition) {
              ratting.width((Math.floor(perc / 10)) * 10 + '%');
            } else {
              ratting.width((Math.ceil(perc / 10)) * 10 + '%');
            }

          });
        }
      };
    }
  ]);
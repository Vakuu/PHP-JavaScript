angular.module('slamdunk')
  .directive('sdnSkillsRating', ['$window', '$compile', 'sdnVersion', 'networkService', '$timeout',
    function($window, $compile, sdnVersion, networkService, $timeout) {
      'use strict';
      return {
        restrict: "E",
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-skills-rating.html",
        link: function(scope, element, attrs, ctrl) {

          scope.editSkills = false;

          scope.skill = {
            offence: {
              three_point: 0,
              mid_range: 0,
              lay_ups: 0,
              ball_handling: 0,
              assits: 0
            },
            deffensive: {
              three_point: 0,
              mid_range: 0,
              lay_ups: 0,
              ball_handling: 0,
              assits: 0
            }
          };

          $timeout(function() {
            scope.skill = {
              offence: {
                three_point: 5,
                mid_range: 5,
                lay_ups: 5,
                ball_handling: 5,
                assits: 5
              },
              deffensive: {
                three_point: 5,
                mid_range: 5,
                lay_ups: 5,
                ball_handling: 5,
                assits: 5
              }
            };
          }, 1000);

          scope.loadSKill = function() {
            scope.skill = {
              offence: {
                three_point: 0,
                mid_range: 0,
                lay_ups: 0,
                ball_handling: 0,
                assits: 0
              },
              deffensive: {
                three_point: 0,
                mid_range: 0,
                lay_ups: 0,
                ball_handling: 0,
                assits: 0
              }
            };
          };

          scope.cursorOnDropdown = false;
          scope.sdnDropDownHover = function() {
            scope.cursorOnDropdown = true;
          };

          scope.sdnDropDownHoverOut = function() {
            scope.cursorOnDropdown = false;
            $('.sdn-dropdown').hide();
          };

          scope.skillMouseLeave = function() {

            console.log("sdn dropdown skill mouse leave");
            $window.setTimeout(function() {
              if (!scope.cursorOnDropdown) {
                $('.sdn-dropdown').hide();
              }
            }, 5000);

          };

          scope.resetSkill = function() {
            scope.skill = {
              offence: {
                three_point: 0,
                mid_range: 0,
                lay_ups: 0,
                ball_handling: 0,
                assits: 0
              },
              deffensive: {
                three_point: 0,
                mid_range: 0,
                lay_ups: 0,
                ball_handling: 0,
                assits: 0
              }
            };
          };

          scope.editSkill = function(s, t, $event) {

            var _skillElement;

            if ($($event.target).hasClass('sdn-ratting'))
              _skillElement = $($event.target).parent('div.sdn-progressbar');
            else
              _skillElement = $($event.target);

            var posX = _skillElement.offset().left,
              ratting = _skillElement.find('.my'),
              posY = _skillElement.offset().top,
              clickPosition = ($event.x - posX),
              perc = (100) - (_skillElement.width() - clickPosition) * 100 / _skillElement.width();

            if (scope.editMode) {
              $(".sdn-dropdown").hide();
              var rate;
              if (ratting.width() >= clickPosition) {

                scope.skill[s][t] = Math.floor(perc / 10);
                rate = (Math.floor(perc / 10)) * 10;
              } else {

                scope.skill[s][t] = Math.ceil(perc / 10);
                rate = (Math.floor(perc / 10)) * 10;
              };

            } else {
              $(".sdn-dropdown").show();
              $(".sdn-dropdown").offset({
                "top": $event.pageY + 12,
                "left": $event.pageX - 12
              });

            };
          };

          scope.changeEditModeFriend = function() {
            scope.resetSkill();
            scope.editMode = true;
          };

          scope.changeEditModeMy = function() {
            scope.resetSkill();
            scope.editMode = true;
          };

          scope.submitRatting = function() {
            scope.editMode = false;
            scope.loadSKill();
          };

          $('body').bind('click', function(e) {
            if (($(e.target).hasClass('sdn-progressbar') || $(e.target).hasClass('my')) && !scope.editMode) {
              $('.sdn-dropdown').show();
            } else {
              $('.sdn-dropdown').hide();
            }
          });

          $('body').find('.sdn-progressbar').hover(function() {
            console.log("Mouse Out");
          });

        }
      };
    }
  ]);
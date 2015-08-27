angular.module('slamdunk')
.directive('snRating',function(){
  'use strict';
  return {
    restrict:'A',
    scope:{
      ratingValue: '=',
      max:'=',
      readonly:'@',
      onRatingSelected:'&'
    },
    link:function(scope,element,attrs){
      var updateStars = function(){
        scope.stars = [];
        for(var i = 0; i < scope.max; i++){
          scope.stars.push({filled: i < scope.ratingValue});
        }
      };
      scope.toggle = function(index) {
        if (scope.readonly && scope.readonly === 'true') {
          return;
        }
        scope.ratingValue = index + 1;
        scope.onRatingSelected({rating: index + 1});
      };

      scope.$watch('ratingValue', function(oldVal, newVal) {
        if (newVal) {
          updateStars();
        }
      });
    },
    template:'<ul class="rating"><li ng-repeat="star in stars" ng-class="star" ng-click="toggle($index)"><label class="no-of-star">{{$index+1}}</label><i class="icon"></i></li></ul>'
  };
});
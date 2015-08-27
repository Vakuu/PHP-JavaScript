'use strict';
angular.module('slamdunk')
  .directive('sdnMediaElement', ['sdnVersion', 'user',
    function(sdnVersion, user) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {
          console.log(attrs);


          $(element).bind('click', function() {
            var modalMedia = $('#modal-media');
            modalMedia.find('.image-wrapper img').attr('src', attrs.largeImage);
            modalMedia.find('span.title').text(attrs.title);
            console.log(modalMedia);
            $('#modal-media').modal('show');
          });
        }
      };
    }
  ]);
//
//https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.awwwards.com%2Fweb-design-awards%2Fantico-setificio-fiorentino&t=Antico+Setificio+Fiorentino
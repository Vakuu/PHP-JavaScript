angular.module('slamdunk')
  .directive('map', function() {
    return {
      restrict: 'E',
      replace: true,
      template: '<div></div>',
      link: function(scope, element, attrs) {
        

        var myOptions = {
          zoom: 15,
          center: new google.maps.LatLng(40.81572208480, -74.82982123960),
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          backgroundColor: "#DDDDDD",
          disableDefaultUI: true
        };
        var map = new google.maps.Map(document.getElementById(attrs.id), myOptions);

        map.set('styles', [{
          featureType: 'road',
          elementType: 'geometry',
          stylers: [{
            color: '#E7845E'
          }, {
            weight: 1
          }]
        }, {
          "featureType": "water",
          "stylers": [{
            "color": "#f5f5f5"
          }]
        }, {
          "featureType": "landscape.natural.terrain",
          "stylers": [{
            "color": "#fff700"
          }]
        }, {
          "featureType": "poi",
          "stylers": [{
            "color": "#dbdbdb"
          }]
        }, {
          "elementType": "labels.text.fill",
          "stylers": [{
            "color": "#000000"
          }]
        }]);

        // google.maps.event.addListener(map, 'click', function(e) {
        //   scope.$apply(function() {
        //     addMarker({
        //       lat: e.latLng.lat(),
        //       lng: e.latLng.lng()
        //     });

        //     console.log(e);
        //   });

        // }); // end click listener

        addMarker = function(pos) {
          var myLatlng = new google.maps.LatLng(pos.lat, pos.lng);
          var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: "Hello World!"
          });
        } //end addMarker

      }
    };
  });
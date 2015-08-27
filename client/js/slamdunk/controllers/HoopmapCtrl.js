angular.module('slamdunk')
  .controller('HoopmapCtrl', ['$scope', '$rootScope', 'loader', '$templateCache', 'courts_factory', 'geolocation', 'user', 'sharing', '$window', '$timeout', 'country', 'growl', 'sdnProcess', '$upload', 'token', 'PubNub',
    function($scope, $rootScope, loader, $templateCache, courts_factory, geolocation, user, sharing, $window, $timeout, country, growl, sdnProcess, $upload, token, PubNub) {
      'use strict';

      //Initial Loading Courts
      $scope.courts = [];
      $scope.myMarkers = [];
      $scope.activeUser = {};

      user.activeUser(function(data) {
        $scope.activeUser = data;
      }, function(err) { });

      //Controller Name
      $scope.ctrlName = 'HoopmapCtrl';

      //Fill create court tab fields
      $scope.court = $scope.court || {};

      //get countries name
      country.list().success(function(data) {
        $scope.countries = data.Countries;

        //TODO : Select Country and load all the courts of that counrty


      }).error(function() {
        growl.addErrorMessage("Error while loading country list");
      });

     
      //All Maps functions
      var google = window.google;

      //Fill address field based on LatLng
      function fillAddressFields(latLng) {
        $scope.court.address = {};
        $scope.loadingAddress = true;
        geolocation.getPlace(latLng, function(loc) {
          $scope.court.address = {
            street: loc.address,
            city: loc.city,
            country: loc.country
          };
          $scope.court.address.map_street = loc.address;
          $scope.court.address.map_city = loc.city;
          $scope.court.address.map_country = loc.country;
          $scope.loadingAddress = false;
        }, function() {
          //set error
          //not able to get address
          alert("not able to get address");
        });
      };

      //Reset Court Object will reset Create court form
      var resetForm = function() {
        $scope.court = {};
        $scope.court.rating = 3;
        $scope.court.num_hoops = 5;
        $scope.court.ctype = "street";
      };

      //Initially reset the Form
      resetForm();
   
      //All hoopmap Utils functions
      var hoopmapUtils = {
        drawMarker: function(latLang, isDraggable, court, isNewCourt) {
          var markerLabel;
          //'<div class="hoopmap-courtking-img"></div><i class="hoopmap-marker-img icon marker_'+ (court ? court.ctype : 'indoor') +'_black"></i>' + (court ? '<i class="hoopmap-icon">'+ (court.checks ? court.checks.length : 0) +'</i>' : '')

          if (isNewCourt) {
            markerLabel = '<i class="hoopmap-marker-img icon marker_' + (court ? court.ctype : 'indoor') + '_orange"></i>';
          } else {
            //http://squizzes.s3.amazonaws.com/wp-content/uploads/2012/08/King-Henry-II-bullet.jpg
            var kingOfCourt = court.king ? '<img src="' + court.king.photo_t_url + '"/>' : "";
            markerLabel = '<div class="hoopmap-courtking-img">' + kingOfCourt + '</div><i class="hoopmap-marker-img icon marker_' + (court ? court.ctype : 'indoor') + '_black"></i>' + (court ? '<i class="hoopmap-icon">' + (court.playersOnCourtToday ? court.playersOnCourtToday.length : 0) + '</i>' : '');
          }

          var newMarker = new Marker({
            map: $scope.myMap,
            position: latLang,
            draggable: isDraggable,
            animation: google.maps.Animation.BOUNCE,
            zIndex: 9,
            icon: {
              path: SQUARE_PIN,
              fillColor: 'transparent',
              fillOpacity: 1,
              strokeColor: '',
              strokeWeight: 0,
              scale: 1 / 3,
              anchor: new google.maps.Point(-50, 45)
            },
            //label: '<div class="hoopmap-courtking-img"></div><i class="hoopmap-marker-img icon marker_'+ (court ? court.ctype : 'indoor') +'_black"></i>' + (court ? '<i class="hoopmap-icon">'+ (court.checks ? court.checks.length : 0) +'</i>' : '')
            label: markerLabel
          });


          //change create court address based on marker position
          google.maps.event.addListener(newMarker, 'dragend', function(data) {
            newMarker.setAnimation(google.maps.Animation.BOUNCE);
            fillAddressFields({
              lat: data.latLng.k,
              lng: data.latLng.A
            });
          });

          if (isNewCourt) {};

          return newMarker;
        },
        removeMarker: function(marker, index) {
          $scope.myMarkers.splice(index, 1);
          marker.setMap(null);
          marker = null;
          index = null;
        }
      };

      //Add new court to database
      $scope.addCourt = function() {
        $scope.frmCreateCourt.$setPristine();

        sdnProcess.show("Please wait we are creating court...");
        if (!$scope.activeMarker) {
          alert("Form is not valid");
          return;
        }

        var court = {
          name: $scope.court.name,
          ctype: $scope.court.ctype,
          photo: "",
          photo_url: "",
          photo_t_url: "",
          photo_m_url: "",
          loc: [$scope.activeMarker.position.A, $scope.activeMarker.position.k],
          address: {
            country: ($scope.court.address && $scope.court.address.country) || "",
            state: "",
            city: ($scope.court.address && $scope.court.address.city) || "",
            zip: "",
            street: ($scope.court.address && $scope.court.address.street) || ""
          },
          phone: "",
          website: "",
          email: "",
          company: "",
          userId: $scope.activeUser._id,
          num_hoops: $scope.court.num_hoops,
          hheight: $scope.court.hheight,
          lines: $scope.court.lines,
          surface: $scope.court.surface,
          net: "",
          nlight: "",
          desc: "",
          teams: "",
          games: [],
          checks: [],
          events: [],
          deleted: false,
          fake: false,
          albums: [],
          rating: $scope.court.rating
        };

        courts_factory.register(court).success(function(c) {
          //
        
          $scope.courts.push(court);
          
          //Upload court image now          
          sdnProcess.show("Now we are uploading image...");
          $scope.start(0, c._id);
          
          //add newsly created marker in the hoopmap
          var marker = hoopmapUtils.drawMarker($scope.activeMarker.position, false, court);
          marker.metadata = {
            court: court
          };
          $scope.myMarkers.push(marker);
          hoopmapUtils.removeMarker($scope.activeMarker, $scope.activeMarkerIndex);

          //add success message here
          growl.addSuccessMessage(court.name + " created!");

          $scope.court = {};
          $scope.activeMarker = null;

          //refresh data after creating new court and open filter tab 
          $scope.CourtFilter();
          loadSDNRecomendandNewCourt();
          $('.hoopmap-tabs a[data-target="#courtfilters"]').tab('show');
          resetForm();

        }).error(function() {
          growl.addErrorMessage("Error while creating court");  
        });
      };

      var initMarkers = function() {
        angular.forEach($scope.courts, function(currCourt) {
          var latLng = new google.maps.LatLng(currCourt.loc[1], currCourt.loc[0]);
          var marker = hoopmapUtils.drawMarker(latLng, false, currCourt);
          marker.metadata = {
            court: currCourt
          };
          $scope.myMarkers.push(marker);
        });
      };

      $scope.onMapIdle = function(message) {
   
        if ($scope.myMarkers === undefined) {
          $scope.myMarkers = [];
          initMarkers();
        }
      };

      $scope.imgFile = "";
      $scope.onFileSelect = function($files) {
      
        $scope.imgFile = $files[0];
      };

      //Court image upload function
      $scope.start = function(index, _cid) {
        $scope.upload = $upload.upload({
          url: 'http://sdapi.herokuapp.com/upload/main_court?access_token=' + token.get, //upload.php script, node.js route, or servlet url
          // method: 'POST' or 'PUT',
          headers: {
            uid: $scope.activeUser._id,
            cid: _cid
          },
          // withCredentials: true,
          data: {
            photo: $scope.myModel
          },
          file: $scope.imgFile, // or list of files: $files for html5 only
          /* set the file formData name ('Content-Desposition'). Default is 'file' */
          //fileFormDataName: myFile, //or a list of names for multiple files (html5).
          /* customize how data is added to formData. See #40#issuecomment-28612000 for sample code */
          //formDataAppender: function(formData, key, val){}
        }).progress(function(evt) {
       
        }).success(function(data, status, headers, config) {
          // file is uploaded successfully
          sdnProcess.hide();
        
        });
      };

      $scope.resetInputFile = function() {
        var elems = document.getElementsByTagName('input');
        for (var i = 0; i < elems.length; i++) {
          if (elems[i].type == 'file') {
            elems[i].value = null;
          }
        }
      };

      $scope.abort = function(index) {
        $scope.upload[index].abort();
        $scope.upload[index] = null;
      };

      $scope.setBboundsOnMarker = function() {
        
        if($scope.myMarkers.length > 0) {
                
          var markers = $scope.myMarkers;
          var bounds = new google.maps.LatLngBounds();
  
          for(i=0;i<$scope.myMarkers.length;i++) {
            bounds.extend(markers[i].getPosition());
          }
  
          $scope.myMap.fitBounds(bounds);
        }

      };

      // google.maps.event.addListener($scope.myMap, "center_changed", function() {
      //   // infoWnd.setContent(mapCanvas.getCenter().toUrlValue());
      //   // infoWnd.setPosition(mapCanvas.getCenter());
      //   // infoWnd.open(mapCanvas);
      //   // //console.log();
      //   // $scope.myMap.setContent(mapCanvas.getCenter().toUrlValue());
      //   console.log("location changed");
      // });

      //Chnage hoopmap marker image on court type change
      $scope.$watch("court.ctype", function(newValue, oldValue) {
        if ($scope.activeMarker) {
          var oldmarker = $scope.activeMarker;
          hoopmapUtils.removeMarker($scope.activeMarker, $scope.activeMarkerIndex);
          var marker = hoopmapUtils.drawMarker(oldmarker.position, true, $scope.court, true);
          $scope.myMarkers.push(marker);
          $scope.activeMarker = marker;
          $scope.activeMarkerIndex = $scope.myMarkers.length - 1;

        }
      });

      //Court Filter
      $scope.CourtFilter = function() {

        var filteredCourts = [];

        changeCourtCount();

        var obj = {
          city: $scope.filter.city,
          country: $scope.filter.country
        };

        if ($scope.filter.city)
          obj.city = $scope.filter.city;
        if ($scope.filter.county)
          obj.country = $scoep.filter.country;


        if ($scope.filter.ctype) {
          if ($scope.filter.ctype == 'active') {
            obj.active = true;
          } else {
            obj.ctype = $scope.filter.ctype;
          }
        }

        courts_factory.filter(obj).success(function(c) {
          ////
          filteredCourts = c;

          initMarkers();
          angular.forEach($scope.myMarkers, function(v, k) {
            v.setMap(null);
          });

          $scope.myMarkers = [];
          angular.forEach(filteredCourts, function(currCourt) {
            var latLng = new google.maps.LatLng(currCourt.loc[1], currCourt.loc[0]);
            var marker = hoopmapUtils.drawMarker(latLng, false, currCourt);
            marker.metadata = {
              court: currCourt
            };
            $scope.myMarkers.push(marker);
          });
          $scope.setBboundsOnMarker();
          if (obj.city && obj.country) {
            
            if ($scope.myMarkers[0]) {
              var newll = new google.maps.LatLng($scope.myMarkers[0].position.k, $scope.myMarkers[0].position.A);

              //$scope.myMap.setCenter(newll);
              ///$scope.myMap.setZoom(14);
            }
          }

          ////

        }).error(function(err) {
          //TODO: Add error message here

        });
      };


      //remove active court when tab change to filter rcourt
      $scope.tabChange = function(id) {
        if (id == "filtercourt") {
          if ($scope.activeMarker) {
            hoopmapUtils.removeMarker($scope.activeMarker, $scope.activeMarkerIndex);
            $scope.court = {};
            $scope.activeMarker = null;

            resetForm();
          }
        }
        if (id == "createcourt") {
          if (!$scope.activeMarker) {
            var center = $scope.myMap.getCenter();
            var mev = {
              stop: null,
              latLng: new google.maps.LatLng(center.k, center.A)
            }
            google.maps.event.trigger($scope.myMap, 'click', mev);
          }
        }
      };

      //

      /// We have used Angular UI Map (http://angular-ui.github.io/ui-map/) 
      /// For all the Google Map operation
      /// You can visit http://angular-ui.github.io/ui-map/ For more information

      ///All Angular UI Methods

      //Hoopmap center will be based upon user location

      ///google.maps.MapOptions object specification
      ///https://developers.google.com/maps/documentation/javascript/reference#MapOptions

      $scope.myLocationLoad = function() {
        user.location(function(loc) {

          var newll = new google.maps.LatLng(loc.lat, loc.lng);
          $scope.myMap.setCenter(newll);

          // courts_factory.nearbyCourts({
          //   lat: loc.lat,
          //   lng: loc.lng
          // }).success(function(result) {
          //   $scope.courts = result;

          //   initMarkers();
          //   $scope.myMap.setZoom(14);
          // }).error(function(err) {});

        }, function() {
          //alert($rootScope.activeUser.iplocation.loc[0]);
          //TODO: if location is not shared than load get user country from its model
          var newll = new google.maps.LatLng($rootScope.activeUser.iplocation.loc[0], $rootScope.activeUser.iplocation.loc[1]);
          $scope.myMap.setCenter(newll);
          //$scope.myMap.setZoom(5);
          var bounds = new google.maps.LatLngBounds();
          //bounds.extend(myPlace);
          bounds.extend(newll);
          $scope.myMap.fitBounds(bounds);
        });
      };
      $scope.myLocationLoad();

      $scope.mapOptions = {
        //center: ll,
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        animation: google.maps.Animation.DROP,
        zoomControlOptions: {
          style: google.maps.ZoomControlStyle.LARGE,
          position: google.maps.ControlPosition.TOP_RIGHT
        },
        panControlOptions: {
          position: google.maps.ControlPosition.TOP_RIGHT
        }
      };

      //Set google map center using Lat Lng
      $scope.setMarkerPosition = function(marker, lat, lng) {
        marker.setPosition(new google.maps.LatLng(lat, lng));
      };

      function defaultButtonVisiblity() {
        $scope.displayNoShow = false;
        $scope.displayShowUp = true;
        $scope.selectedCourtInfo.playersAttendingToday.forEach(function(v) {
          if (v._id == $scope.activeUser._id) {
            $scope.displayNoShow = true;
            $scope.displayShowUp = false;
          }
        })
      };

      //Display court ditails on marker click
      $scope.openMarkerInfo = function(marker) {
        if (marker.metadata) {

          $('.hoopmap-tabs a[data-target="#mapdata"]').tab('show');

          $scope.selectedCourtInfo = marker.metadata.court || {};

          defaultButtonVisiblity();

        } else {
          $('.hoopmap-tabs a[data-target="#courtcreate"]').tab('show');
        }
      };

      $scope.setZoomMessage = function(zoom) {
        $scope.zoomMessage = "You just zoomed to " + zoom + "!";
      };

      //
      $scope.addMarker = function($event, $params) {

        if ($('#hoopmap .nav-tabs .active').text().trim() == "CREATE COURT") {
          //fill address information on new markup addition
          fillAddressFields({
            lat: $params[0].latLng.k,
            lng: $params[0].latLng.A
          });

          //Remove marker if any one exist which is not saved
          if ($scope.activeMarker) {
            hoopmapUtils.removeMarker($scope.activeMarker, $scope.activeMarkerIndex);
          }

          //Create new marker
          var marker = hoopmapUtils.drawMarker($params[0].latLng, true, $scope.court, true);
          $scope.myMarkers.push(marker);
          $scope.activeMarker = marker;
          $scope.activeMarkerIndex = $scope.myMarkers.length - 1;

          $('.hoopmap-tabs a[data-target="#courtcreate"]').tab('show');

        }

      };
      ///End Angilar UI Methods

      function loadSDNRecomendandNewCourt() {
        ///sdn recommended courts
        $scope.loadSDNCourt = true;
        courts_factory.sdnCourts().success(function(c) {
          $scope.SDNCourts = c;
          $scope.loadSDNCourt = false;
        }).error(function() {
          $scope.loadSDNCourt = false;
          $scope.SDNCourts = [];
        });

        ///lastest courts
        $scope.lastRegisteredLoading = true;
        courts_factory.lastRegistered().success(function(c) {
          $scope.latestCourts = c;
          $scope.lastRegisteredLoading = false;
        }).error(function() {
          $scope.lastRegisteredLoading = false;
          $scope.latestCourts = [];
        });
      }

      loadSDNRecomendandNewCourt();

      ///loading city on country change
      $scope.filter = {
        cities: [],
        ctype: {}
      };

      ///
      $scope.countryChange = function() {
        if ($scope.filter.country && $scope.filter.country != "") {
          $scope.setAddressLocationandZoom($scope.filter.country, 18);
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

      ///
      $scope.setAddressLocationandZoom = function(address, zoom) {
        globalClass.getLatLongFromAddress($scope.filter.country, function(results) {
          var obj = results[0].geometry.location;
          var newll = new google.maps.LatLng(obj.A, obj.k);
          
          $scope.myMap.setCenter(obj);
          $scope.myMap.setZoom(zoom);
        });
      };
      $scope.total_indoor = $scope.total_street = $scope.total_active = "--";
      // $scope.total_street = 0;
      // $scope.total_active = 0;

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

      function reloadmyMarker() {
        courts_factory.get($scope.selectedCourtInfo._id).success(function(newdata) {
          $scope.myMarkers.forEach(function(msg, k) {
           
            if (msg.metadata.court._id == $scope.selectedCourtInfo._id) {
              $scope.myMarkers[k].metadata.court = $scope.selectedCourtInfo = newdata;
            }
          });
        }).error(function() {

        });
      };

      $scope.showup = function(_cid) {
        loader.show();

        courts_factory.showup({
          cid: _cid,
          uid: $scope.activeUser._id
        }).success(function(data) {
          loader.hide();
          $scope.displayNoShow = true;
          $scope.displayShowUp = false;
          reloadmyMarker();
        }).error(function(errr) {
         
        });
      };

      $scope.noshow = function(_cid) {
        loader.show();

        courts_factory.noshow({
          cid: _cid,
          uid: $scope.activeUser._id
        }).success(function(data) {
          $scope.displayNoShow = false;
          $scope.displayShowUp = true;
          loader.hide();
          reloadmyMarker();
        }).error(function(errr) {
        
          loader.hide();
        });
      };

      $scope.shareCourtFB = function(pic, caption, cid, address) {
        sharing.facebook({
          name: caption,
          caption: 'Slamdunk Network',
          description: address,
          link: "http://" + $window.location.host + '/%23%court-profile/' + cid,
          picture: pic
        })
        //sharing.fbShare("http://" + $window.location.host + "/%23/court-profile/" + cid, caption, "Slamdunk Netwrork Court", "http://moodle.dallastown.k12.pa.us/file.php/2958/basketball-court.jpg", 500, 500);
      };

      $scope.shareCourtTwitter = function(caption, cid) {
        sharing.twitter({
          link: "http://" + $window.location.host + '/%23/court-profile/' + cid,
          caption: caption
        });
      };

    }
  ]);
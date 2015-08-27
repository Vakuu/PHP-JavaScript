var globalClass = globalClass || {};

//add active class in sub nav active link
globalClass.selectActiveSubNav = function(obj) {

  var obj = obj || {};

  $(obj.element).find("a").each(function() {

    var elm = $(this);

    elm.each(function() {
      elm.attr('href') == window.location.pathname ? elm.addClass(obj.class) : elm.removeClass("active");
    });

  });
};

//get place information based on lat lng
globalClass.getGeocodeData = function() {

  var loc = arguments[0],
    callback = arguments[1],
    latlng = new google.maps.LatLng(loc.lat, loc.lng),
    geocoder = geocoder || new google.maps.Geocoder();
  console.log(loc);
  geocoder.geocode({
    'latLng': latlng
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var data = data || {};

      data.address = results[0]["formatted_address"];
      results = results[0]["address_components"];

      var tmpCity;
      angular.forEach(results, function(v, k) {

        angular.forEach(v.types, function(v_, k_) {

          if (v_ == "country") {
            data.country = v.long_name;
          }

          if (v_ == "administrative_area_level_1") {
            data.state = v.long_name;
            tmpCity = v.long_name;
          }

          if (v_ == "administrative_area_level_2") {
            data.city = v.long_name;
          }


        });

        if (data.city == "" || !data.city) {
          data.city = tmpCity;
        }

      });

      callback(data);
    };
  });
};

globalClass.getLatLongFromAddress = function(address, cb) {
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
      // map.setCenter(results[0].geometry.location);
      // var marker = new google.maps.Marker({
      //   map: map,
      //   position: results[0].geometry.location
      // });
      cb(results);
    } else {
      alert("Geocode was not successful for the following reason: " + status);
    }
  });
};

//get age from dob YYYY-MM-DD
globalClass.getAge = function(dob) {

  var year = parseInt(dob.split('-')[0]),
    month = parseInt(dob.split('-')[1]),
    day = parseInt(dob.split('-')[2]);

  var today_date = new Date();
  var today_year = today_date.getFullYear();
  var today_month = today_date.getMonth();
  var today_day = today_date.getDate();
  var age = today_year - year;

  if (today_month < (month - 1)) {
    age--;
  }
  if (((month - 1) == today_month) && (today_day < day)) {
    age--;
  }
  return age;
};

globalClass.check = false;
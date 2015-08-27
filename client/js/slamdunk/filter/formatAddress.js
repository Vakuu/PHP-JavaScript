angular.module('slamdunk')
  .filter('formatAddress', function() {
    return function(input) {

      var obj = input;
      var str = "";

      if (obj && obj != null) {
        if (obj.street && obj.street != null)
          str = obj.street;

        if ((obj.city && obj.city != null) && (obj.street && obj.street != null))
          str += ", " + obj.city;
        else
          str += obj.city;
      }

      return str;
    }
  })
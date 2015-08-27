angular.module('slamdunk')
  .filter('doubleNumber', function() {
    return function(input, number) {

      var text;

      if (!number) number = 2;

      if (number == 2) {
        text = (input < 10 ? "0" : "") + input;
      } else if (number == 3) {
        if (input < 10)
          text = (input < 10 ? "00" : "") + input;
        else if (input < 100)
          text = (input < 100 ? "0" : "") + input;
      }

      return text;
    }
  })
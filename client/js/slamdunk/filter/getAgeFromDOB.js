angular.module('slamdunk')
  .filter('getAgeFromDOB', function() {
    return function(input) {

      if(!input)
        return "--";

      var dob = input;
      
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
    }
  })
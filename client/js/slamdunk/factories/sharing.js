'use strict';
angular.module('slamdunk')
  .factory('sharing', ['$cookieStore', 'fb_app_id', '$window',
    function($cookieStore, fb_app_id, $window) {
      return {
        openDialog: function(URL) {

          var left = ($window.screen.width / 2) - (400 / 2);
          var top = ($window.screen.height / 2) - (300 / 2);
          $window.open(URL, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=" + top + ", left=" + left + ", width=400, height=300");

        },
        facebook: function(obj) {
          // var URL =
          //   "https://www.facebook.com/dialog/feed?" +
          //   "app_id=" + fb_app_id +
          //   "&display=popup" +
          //   "&picture=" + obj.picture +
          //   "&caption=" + obj.caption +
          //   "&link=" + obj.link.replace('#', '%23') +
          //   "&redirect_uri=" + obj.redirect_uri.replace('#', '%23');

          FB.ui({
              method: 'feed',
              name: obj.name,
              caption: obj.caption ? obj.caption : '',
              description: (obj.description ? obj.description : ''),
              link: obj.link.replace('#', '%23'),
              picture: obj.picture ? obj.picture : ''
            },
            function(response) {
              if (response && response.post_id) {
                //callback
                //alert('Post was published.');
              } else {
                //alert('Post was not published.');
              }
            }
          );

          //this.openDialog(URL);
        },
        twitter: function(obj) {
          var URL =
            "https://twitter.com/share?" +
            "&url=" + obj.link.replace('#', '%23') + "&text" + obj.caption;
          this.openDialog(URL);
        }
      }
    }
  ]);


// https://www.facebook.com/dialog/feed?
// app_id=150251821812646
// &display=popup&caption=An%20example%20caption
// &picture=http://www.forumpiece.com/data/avatars/l/24/24777.jpg?1393262966 
// &link=http://slamdunk.herokuapp.com/network
// &redirect_uri=http://slamdunk.herokuapp.com
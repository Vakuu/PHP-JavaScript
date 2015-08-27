'use strict';
angular.module('slamdunk')
  .directive('sdnUserProfilePicUploadElement', ['sdnVersion', 'user', 'token', '$upload', 'loader',
    function(sdnVersion, user, token, $upload, loader) {
      return {
        restrict: 'E',
        templateUrl: sdnVersion + "/templates/directive-templates/sdn-user-profile-pic-upload.html",
        link: function(scope, element, attrs) {

          scope.title = attrs.title ? attrs.title : "UPLOAD MAIN IMAGE";
          scope.cover_photo = attrs.converPhoto;
          
          var options = { };

          if (attrs.whose == "user") {
            options = {
              url: 'http://sdapi.herokuapp.com/upload/user?access_token=' + token.get,
              headers: {
                ////'Content-Type': false,
                'uid': attrs.uid
              }
            }
          } else if (attrs.whose == "court") {
            options = {
              url: 'http://sdapi.herokuapp.com/upload/main_court?access_token=' + token.get,
              headers: {
                /////'Content-Type': false,
                'uid': attrs.uid,
                'cid': attrs.cid
              }
            }
          }

          scope.onFileSelect = function($files) {
            //$files: an array of files selected, each file has name, size, and type.
            //
            scope[attrs.uploadstart]();
            for (var i = 0; i < $files.length; i++) {
              var file = $files[i];
              scope.upload = $upload.upload({
                url: options.url, //upload.php script, node.js route, or servlet url
                method: "POST",
                headers: options.headers,
                // headers: {'header-key': 'header-value'},
                // withCredentials: true,uploadstart
                data: {
                  photo: scope.myModelObject,
                },
                file: file, // or list of files: $files for html5 only
                /* set the file formData name ('Content-Desposition'). Default is 'file' */
                //fileFormDataName: myFile, //or a list of names for multiple files (html5).
                /* customize how data is added to formData. See #40#issuecomment-28612000 for sample code */
                //formDataAppender: function(formData, key, val){}
              }).progress(function(evt) {
                scope.progress = parseInt(100.0 * evt.loaded / evt.total);

                console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
              }).success(function(data, status, headers, config) {
                // file is uploaded successfully
                if (attrs.whose == "user") {
                  console.log(data, "upser profile pic upload successfully");
                  user.updateActiveUser(data);
                  scope.cover_photo = data.photo.image_large_url;
                  scope[attrs.callback](data.photo.image_large_url);
                  $('#modal-upload-pro-pic').modal('hide');
                } else {
                  scope.cover_photo = data.mainImage.image_large_url;
                  scope[attrs.callback](data.mainImage.image_large_url);
                  $('#modal-upload-pro-pic').modal('hide');
                }

              });
              //.error(...)
              //.then(success, error, progress); 
              //.xhr(function(xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
            }
            /* alternative way of uploading, send the file binary with the file's content-type.
               Could be used to upload files to CouchDB, imgur, etc... html5 FileReader is needed. 
               It could also be used to monitor the progress of a normal http post/put request with large data*/
            // $scope.upload = $upload.http({...})  see 88#issuecomment-31366487 for sample code.
          };

        }
      };
    }
  ]);
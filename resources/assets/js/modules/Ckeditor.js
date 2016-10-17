import * as ajax from '../ajax.js'

let Ckeditor = (function() {

    var token = $(".draft-email");

    var tokObj = [];
    token.each(function(){
        tokObj.push({id: $(this).data('draft-id'), name: $(this).data('draft-email')});
    })

  let $ckeditor = $('.ckeditor');

    function init() {
        if ($ckeditor.length) {

          $("#inputAdmin").tokenInput(`/${ajax.pathWho}/get_admins_email`, {
              theme: "facebook",
              tokenLimit: null,
              prePopulate: tokObj
          });
          $('.radio').on('change', function (event) {
              switch (event.currentTarget.defaultValue) {
                  case 'all':
                      $(".admins").hide();
                      break;
                  case 'some':
                      $(".admins").show();
                      break;
              }
          });

        if ($ckeditor) {
            CKEDITOR.replace('text');
        }
      }
    }

    return {
      init
    }


})();

export default Ckeditor;

        



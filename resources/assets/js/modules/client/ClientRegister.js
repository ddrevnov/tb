var ClientRegister = (function() {

  var $clientRegistration = $('#clientRegistration');



  function valid() {
    $clientRegistration.on('submit', function(e) {
      e.preventDefault();
      var $email = $clientRegistration.find('input[type="email"]');
      var emailval = $email.val();

      var data = {
        email: emailval
      };

      console.log('front data', data);

      $.ajax({
          method: "POST",
          url: "/check_email",
          dataType: "json",
          data: data
        })
        .done(function( res ) {
          if (!res) {
            $email.addClass('errorFormValid').focus();
            $email.before(`
            <div class="errorBlock">Пользователь с таким email уже существует. <br>
               Пожалуйста введите другой!
            </div>`
            );

            $email.on('input', function() {
              $('.errorBlock').remove();
              $email.removeClass('errorFormValid');
            });
          } else {
            $clientRegistration.off('submit').submit();
          }
        });
    });
  }


  return {
    init: function() {
      valid();
    }
  }

})();

export default ClientRegister;

@extends('layouts.auth')

@section('content')

    <div class="login">

        <img src="{{ asset('images/login-logo.png') }}" alt="" class="login__logo">

        <form class="login__form" id="loginForm"  role="form" method="POST">
        <div id="loginSuccessMess">Ihr Passwort geändert wurde, überprüfen Sie bitte die E-Mail .</div>
        <div id="loginErrorEmailOrPassword" class="vue-error">Ungültige E -Mail oder Passwort</div>
            {!! csrf_field() !!}
            <input type="email" name="email" class="login__input" placeholder="Benutzername" value="{{ old('email') }}">
            <input type="password" name="password" class="login__input" placeholder="Passwort">
            <input class="login__submit btn btn--red" type="submit" value="Anmelden">
        </form>

        <form id="forgotPassForm" action="" method="post">
            <span id="close"></span>
            <input type="checkbox" id="forgotpass" class="del" checked="checked"/>
            <label for="raz" class="del">
                <a href="javascript:void(0);" id="forgotPassword" style="text-decoration: none;" class="a_hover">Passwort vergessen?</a>
                </label>
            <div><div class="b-popup" id="popup1">
                    <div class="b-popup-content">
                        <div class="tel-field" >
                            <input name="forgotpass" type="tel" placeholder="E-mail" class="login__input" />
                            <div id="loginErrorMess" class="vue-error">Ungültige E -Mail</div>
                        </div>
                        <div class="info-field" ></div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <p>
                        <input class="login__submit btn btn--red" type="submit" value="Wiederherstellung" /></p>
                        <a id="exitBtn" href="javascript:void(0);">exit</a>
                    </div>
                </div></div>
            <div class="b-container">
            </div>
        </form>

    </div>

    <script src="https://code.jquery.com/jquery-2.0.2.min.js"></script>

    <script>
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }

    function sendAjax(data, path) {
     var req = $.ajax({
        type     : 'POST',
        url      : path,
        dataType : 'JSON',
        data     : data
      });
      return req;
    }

        $(document).ready(function(){
          var $loginErrorMess = $('#loginErrorMess');
          var $loginSuccessMess = $('#loginSuccessMess');
          var $loginErrorEmailOrPassword = $('#loginErrorEmailOrPassword');

             $("#popup1").hide();
             $loginErrorMess.hide();
             $loginSuccessMess.hide();
             $loginErrorEmailOrPassword.hide();

            $(document).on('click', '#forgotPassword', function() {
                $("#popup1").show();
            });

            $(document).on('click', '#exitBtn', function() {
               $("#popup1").hide();
            });

            $(document).on('submit', '#loginForm', function(e) {
              e.preventDefault();

              var $this = $(this);
               var data = getFormData( $this );
               var path = '/login';

               sendAjax(data, path)
                .done(function(res) {
                  if (res) {
                    $loginErrorEmailOrPassword.hide();
                    window.location.href = res.url;
                    // $this.attr('action', '/login').off('submit').submit();
                  } else {
                    $loginErrorEmailOrPassword.show();
                  }

                });

            });

            $(document).on('submit', '#forgotPassForm', function() {
             var $this = $(this);
             var data = getFormData( $this );
             var path = 'forgotpass';
             var $btn = $this.find('[type="submit"]');

            $btn.prop('disabled', true).addClass('is-disabled');

               sendAjax(data, path)
                .done(function(res) {
                  var isCheck = !!(+res[0]);

                  if (isCheck) {
                    $btn.prop('disabled', false).removeClass('is-disabled');
                    $loginSuccessMess.show();
                    $loginErrorMess.hide();
                    $("#popup1").hide();
                  } else {
                    $btn.prop('disabled', false).removeClass('is-disabled');
                    $loginErrorMess.show();
                    $loginSuccessMess.hide();
                  }

                });

                return false;
            });
        });
    
    </script>

@endsection


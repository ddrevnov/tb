{{--@extends('layouts.layoutClient')--}}
{{--@section('login')--}}
<aside class="client-aside">

    <form action="/client/check" method="post" class="login-form" id="loginForm">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input class="login-form__input login-form__input--email" type="text" name="email"
               placeholder="Ihre E-Mail">
        <input class="login-form__input login-form__input--pass" type="password" name="password"
               placeholder="Password">
        <input class="login-form__checkbox" type="checkbox" id="confirm" name="confirm">
        <label for="confirm">Angemeldet bleiben</label>
        <input class="login-form__submit" type="submit" value="login">
        <div><a href="/client/registration">Registrieren</a>
    </form> ·
        <form action="forgotpass" method="post" xmlns="http://www.w3.org/1999/html">
            <span id="close"></span>
            <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
        <input type="checkbox" id="forgotpass" class="del" checked="checked"/><label for="raz" class="del">
                <a href="javascript:PopUpShow()" style="text-decoration: none;" class="a_hover">Passwort vergessen?</a></label>
            <div><div class="b-popup" id="popup1">
                    <div class="b-popup-content">
                        <div class="tel-field" >
                            <input name="forgotpass" type="tel" placeholder="E-mail" class="login__input" />
                        </div>
                    <div class="info-field" ></div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <p style="text-align: left;"><input class="login__submit btn btn--red" type="submit" value="Wiederherstellung" /></p>
                        <a href="javascript:PopUpHide()">exit</a>
                </div>
            </div></div>
        <div class="b-container">
        </div>
    </form></div>

</aside>
{{--@endsection--}}
<script>
$(document).ready(function(){
    PopUpHide();
});
function PopUpShow(){
    $("#popup1").show();
}
function PopUpHide(){
    $("#popup1").hide();
}
</script>

{{--@endsection--}}

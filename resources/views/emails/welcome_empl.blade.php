<div style="background: #f3f3f3; width: 100%;">
<div style="margin: 0 auto; width: 701px;">
<div style="width: 699px; background: #ffffff; border: 1px solid #e9e9e9;">
  <img src="http://tb.hqsale.com/wp/wp-content/themes/bootstrap-basic/img/logo.jpg" alt="timebox24" style="margin: 0 10px 0 30px;">
</div>

<div style="width: 629px; background: #ffffff; border: 1px solid #e9e9e9; border-top: 0px solid; padding: 15px 35px;">
  <h2>Ihr Account wurde erfolgreich aktiviert!</h2>

  <div style="margin-bottom: 30px;">
      <p style="margin: 0px;">Sehr geehrte <strong>{{($gender == 'male') ? 'Herr' : 'Frau'}} {{$name}},</strong></p>
      <p style="margin: 0px;">Ihr Account wurde erfolgreich aktiviert.</p>
  </div>

  <div style="margin-bottom: 30px;">
    <p style="margin: 0px;">Sie können sich nun mit den folgenden Zugangsdaten bei timebox24 anmelden.</p>
  </div>

  <div style="margin-bottom: 30px;">
    <p style="margin: 0px;"><strong>E-Mail:</strong> {{$email}}</p>
    <p style="margin: 0px;"><strong>Passwort:</strong> {{$password}}</p>
  </div>

  <div style="margin-bottom: 60px;">
    <p style="margin: 0px;">Bei Fragen zu Ihrem Account können Sie sich gerne jederzeit an uns wenden.“</p>
  </div>

  <style>
    .hov_er{
      background: #e64423;
    }
    .hov_er:hover{
      background: #C3371B;
    }
  </style>

  <a href="http://{{$firmlink}}" style="background: #e64423; text-decoration: none; color: #ffffff; padding: 16px 72px 14px 72px; cursor: pointer;">Jetzt loslegen!</a>
  <a href="http://{{$firmlink}}/office" style="background: #e64423; text-decoration: none; color: #ffffff; padding: 16px 72px 14px 72px; cursor: pointer;">Jetzt loslegen OFFICE!</a>

  <div style="margin-bottom: 30px; margin-top: 55px;">
    <p style="margin: 0px;">@lang('emails.best_regards', [], $locale)</p>
    <p style="margin: 0px;">@lang('emails.your_timebox', [], $locale)</p>
  </div>

</div>

<div style="width: 629px; background: #ffffff; border: 1px solid #e9e9e9; border-top: 0px solid; padding: 20px 35px; color: #bcbcbc; font-size: 13px;">
  <p>@lang('emails.please_not_answer', [], $locale)</p>
  <p>@lang('emails.copy_right', [], $locale)</p>
  <img src="http://icons.iconarchive.com/icons/emey87/social-button/32/facebook-icon.png" style="margin-right: 10px; margin-top: 15px; width: 32px; height: 32px;">
  <img src="http://icons.iconarchive.com/icons/emey87/social-button/32/twitter-icon.png" style="margin-right: 10px; margin-top: 15px; width: 32px; height: 32px;">
  <img src="http://icons.iconarchive.com/icons/martz90/circle/32/google-plus-icon.png" style="margin-top: 15px; width: 32px; height: 32px;">
</div>
</div>
</div>
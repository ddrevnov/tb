<div style="background: #f3f3f3; width: 100%; margin: 0;">
<div style="margin: 0 auto; width: 100%;">
<div style="width: 100%; background: #ffffff; border: 1px solid #e9e9e9;">
  <img src="http://timebox24.com/wp/wp-content/themes/bootstrap-basic/img/logo.jpg" alt="timebox24" style="margin: 0 10px 0 30px;">
</div>

<div style="width: 100%; background: #ffffff; border: 1px solid #e9e9e9; border-top: 0px solid; padding: 15px 35px;">

  <div style="margin-bottom: 30px;">

  <p style=" display: inline-block; margin: 0; padding: 0 15px;">{!! $content !!}</p>
    @if($img)
      <img src="{{ $message->embed($img) }}" style="max-height: 240px; max-width: 100%;">
    @endif
    <div style="margin-bottom: 30px; margin-top: 90px;">
      <p style="margin: 0px;">Mit freundlichen Grüßen</p>
      <p style="margin: 0px;">Ihr Timebox24 Kundenservice</p>
    </div>
  </div>
</div>

  <div style="width: 100%; background: #ffffff; border: 1px solid #e9e9e9; border-top: 0px solid; padding: 20px 35px; color: #bcbcbc; font-size: 13px;">
    <p style="text-align: center;">Diese E-Mail würde verschick an {{$email}}
      Sie erhalten diesen E-Mail-Newsletter, weil Sie Mitglied im timebox24 sind.
      Möchten Sie unseren Newsletter nicht mehr beziehen? Klicken Sie hier um ihn abzubestellen.</p>
    <p style="text-align: center;"><img src="http://timebox24.com/images/email_logo.jpg" style="height: 50px;"></p>
  <img src="http://icons.iconarchive.com/icons/emey87/social-button/32/facebook-icon.png" style="margin-right: 10px; margin-top: 15px; width: 32px; height: 32px;">
  <img src="http://icons.iconarchive.com/icons/emey87/social-button/32/twitter-icon.png" style="margin-right: 10px; margin-top: 15px; width: 32px; height: 32px;">
  <img src="http://icons.iconarchive.com/icons/martz90/circle/32/google-plus-icon.png" style="margin-top: 15px; width: 32px; height: 32px;">
  </div>
  </div>
  </div>
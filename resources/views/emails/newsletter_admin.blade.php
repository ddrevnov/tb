<div style="background: #f3f3f3; width: 100%;">
<div style="margin: 0 auto; width: 100%;">

<div style="width: 100%; background: #ffffff; padding: 15px 35px;">


  <div style="margin-bottom: 30px;">

  <p style=" display: inline-block; margin: 0; padding: 0 15px;">{!! $content !!}</p>
    @if($img)
      <img src="{{ $message->embed($img) }}" style="max-height: 240px; max-width: 100%;">
    @endif

  </div>
</div>

  <div style="width: 100%; background: #ffffff; padding: 20px 35px; color: #bcbcbc; font-size: 13px;">
    <p style="text-align: center;">Diese E-Mail würde verschick an {{$email}}
      Sie erhalten diesen E-Mail-Newsletter, weil Sie Mitglied im timebox24 sind.</p>
      <p style="text-align: center;">Möchten Sie unseren Newsletter nicht mehr beziehen? Klicken Sie hier um ihn abzubestellen.</p>
    <p style="text-align: center;"><img src="http://timebox24.com/images/email_logo.jpg" style="height: 50px;"></p>
  </div>
  </div>
  </div>
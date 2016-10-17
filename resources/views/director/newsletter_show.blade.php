@extends('layouts.layoutDirector')
@section('content')
  
<section class="director-benachrichtigung director-main">
  <h1 class="director-content__heading heading heading__h1">Newsletter</h1>

  <div class="director-content" style="min-height: 500px; background-color: #fff;">

    <div style="background: #f3f3f3; width: 100%;">
      <div style="margin: 0 auto; width: 701px;">
        <div style="width: 629px; background: #ffffff; border: 1px solid #e9e9e9;">
          <img src="http://timebox24.com/wp/wp-content/themes/bootstrap-basic/img/logo.jpg" alt="timebox24" style="margin: 0 10px 0 30px;">
        </div>

        <div style="width: 629px; background: #ffffff; border: 1px solid #e9e9e9; border-top: 0px solid; padding: 15px 35px;">
          <h2>{{$mail->subject}}</h2>

          <div style="margin-bottom: 30px;">
            <p style=" display: inline-block; margin: 0; padding: 0 15px;">
              <?php echo htmlspecialchars_decode(stripslashes($mail->text))?>
            </p>
            @if(isset($mail->img) && $mail->img != '0')
              <img src="/images/mailImage/{{ $mail->img }}" style="max-height: 240px; max-width: 100%;">
            @endif
            <div style="margin-bottom: 30px; margin-top: 90px;">
              <p style="margin: 0px;">Mit freundlichen Grüßen</p>
              <p style="margin: 0px;">Ihr Timebox24 Kundenservice</p>
            </div>
          </div>
        </div>

        <div style="width: 629px; background: #ffffff; border: 1px solid #e9e9e9; border-top: 0px solid; padding: 20px 35px; color: #bcbcbc; font-size: 13px;">
          <p style="text-align: center;">Diese E-Mail würde verschick an
            Sie erhalten diesen E-Mail-Newsletter, weil Sie Mitglied im timebox24 sind.
            Möchten Sie unseren Newsletter nicht mehr beziehen? Klicken Sie hier um ihn abzubestellen.</p>
          <p style="text-align: center;"><img src="http://timebox24.com/images/email_logo.jpg" style="height: 50px;"></p>
          <img src="http://icons.iconarchive.com/icons/emey87/social-button/32/facebook-icon.png" style="margin-right: 10px; margin-top: 15px; width: 32px; height: 32px;">
          <img src="http://icons.iconarchive.com/icons/emey87/social-button/32/twitter-icon.png" style="margin-right: 10px; margin-top: 15px; width: 32px; height: 32px;">
          <img src="http://icons.iconarchive.com/icons/martz90/circle/32/google-plus-icon.png" style="margin-top: 15px; width: 32px; height: 32px;">
        </div>
      </div>
    </div>

  </div>

</section>
@stop
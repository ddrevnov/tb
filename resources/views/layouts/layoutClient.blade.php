<!doctype html>
<html class="no-js" lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="locale" content="{{$locale}}">
    <title> client-login </title>

    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300italic,600italic,700italic,400italic,300'
          rel='stylesheet' type='text/css'>
    <!-- Place favicon.ico in the root directory -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('styles/client.css') }}">


    <script src="http://maps.googleapis.com/maps/api/js"></script>
</head>
<body class="client-page">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<div id="app" class="client-container">
    <div class="client-header">

        <div class="client-carousel">
            <div class="client-carousel__next"></div>
            <div class="client-carousel__prev"></div>


            <div id="clientCarousel">
                @if(!$sliders->isEmpty())
                @foreach($sliders as $slide)

                <div class="client-carousel__block">
                    <img class="client-carousel__img" src="/images/sliders/{{$slide->admin_id . '/'. $slide->image}}" alt="">
                </div>

                @endforeach
                @else
                <div class="client-carousel__block">
                    <img class="client-carousel__img" src="/images/sliders/blank_slider.jpg" alt="">
                </div>

                <div class="client-carousel__block">
                    <img class="client-carousel__img" src="/images/sliders/blank_slider2.jpg" alt="">
                </div>
                @endif
            </div>

        </div>
        <nav class="client-nav">
            <ul class="client-nav__list">
                <li class="client-nav__item"><a href="/client/about">{{trans('client_site.about_us')}}</a></li>
                <li class="client-nav__item"><a href="/client/kontact">{{trans('client_site.contacts')}}</a></li>

                <li class="client-nav__item client-nav__item--logo">
                    <a href="/client/">
                        <img src="{{isset($firm_logo) ? $firm_logo->firm_logo : asset('images/default_logo.png') }}" alt=""
                             style="height: 100%; margin: 0px;">
                    </a>
                </li>

                <li class="client-nav__item"><a href="/client/gustebook">{{trans('client_site.guest_book')}}</a></li>
                <li class="client-nav__item"><a href="/booking/">{{trans('client_site.booking')}}</a></li>

            </ul>
        </nav>
    </div>


    @yield('content')


</div>

<footer class="client-footer">
    <div class="client-footer__in">
        <img src="{{ asset('images/client-logo-footer.png') }}" alt="" class="client-footer__logo">

        <div class="client-footer__copy"> Ein Service von GrafikonDesign | Impressum</div>
        <select class="client-footer__locale" v-model="locale" @change.stop="changeLocale" name="locale">
            <option value="de">DE</option>
            <option value="en">EN</option>
            <option value="ru">RU</option>
        </select>
        <ul class="social">
            <li class="social__icon social__icon--twitter"><a href="#"></a></li>
            <li class="social__icon social__icon--facebook"><a href="#"></a></li>
        </ul>
    </div>
</footer>


<script src="{{ asset('scripts/libs/jquery.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery-ui.min.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.formstyler.min.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery-ui-timepicker-addon.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.validate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/vue.validator/2.1.3/vue-validator.min.js"></script>
<script src="{{ asset('scripts/libs/slick.js') }}"></script>
<script src="{{ asset('scripts/libs/remodal.js') }}"></script>

<script src="{{ asset('scripts/client.js') }}"></script>
</body>
</html>

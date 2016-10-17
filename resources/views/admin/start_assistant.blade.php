<!doctype html>
<html class="no-js" lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="locale" content="de">
    <title> admin-dashboard </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/token-input.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/token-input-facebook.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/token-input-mac.css') }}"/>

    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300italic,600italic,700italic,400italic,300'
          rel='stylesheet' type='text/css'>
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="{{ asset('styles/admin.css') }}">
</head>
<body id="assistant" class="page">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<div class="container">
    <div id="tablePreloader"></div>
    <header class="admin-header">
        <div class="admin-header__logo">
            <a href="/office/">
                <img src="" alt="">
            </a>
        </div>

        <div class="admin-header__right admin-header__right--assistant">
            <select @change.stop="changeLang" v-model="locale" name="" id="">
                <option value="de">de</option>
                <option value="en">en</option>
                <option value="ru">ru</option>
            </select>
            <header-time-vue></header-time-vue>
            <div class="admin-header__avatar">
                <a href="#">
                    <img src="/images/default_avatar.png" alt=""
                         style="width: 48px;height: 48px">
                </a>
                <ul>
                    @can('admin_employee')
                    <li><a href="/office/profil_employee">Profil bearbeiten</a></li>
                    @endcan
                    @can('admin')
                    <li><a href="/logout">Abmelden</a></li>
                    @endcan
                </ul>
            </div>
            <div class="admin-header__question"><a href="#"><i></i></a></div>
            <a href="#"></a>
        </div>
    </header>

    <assistant-vue></assistant-vue>
</div>

<div id="sitePreloader"></div>


<script src="{{ asset('scripts/libs/socket.io-1.3.4.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery-ui.min.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.formstyler.min.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.sticky.js') }}"></script>
<script src="{{ asset('scripts/libs/slick.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.validate.min.js') }}"></script>
<script src="{{ asset('scripts/libs/remodal.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery-ui-timepicker-addon.js') }}"></script>
<script src="{{ asset('scripts/libs/spectrum.js') }}"></script>
<script src="{{ asset('scripts/libs/d3.min.js') }}"></script>
<script src="{{ asset('scripts/libs/c3.min.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.tokeninput.js') }}"></script>
<script src="{{ asset('scripts/libs/jquery.tablesorter.js') }}"></script>
<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
<script src="{{ asset('scripts/admin_ajax.js') }}"></script>
<script src="{{ asset('scripts/admin.js') }}"></script>
</body>
</html>

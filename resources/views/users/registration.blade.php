@extends('layouts.layoutClient')
@section('content')

<div class="client-main">
    <aside class="client-aside">
        <registration></registration>
    </aside>
    <div class="client-content">
        <section class="client-login">
            <h1 class="client-login__heading">{{trans('client_site.message_welcome_page')}}</h1>

            <p class="client-login__text">{{trans('client_site.message_please_register')}}</p>
        </section>
    </div>
</div>

@stop

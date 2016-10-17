@extends('layouts.layoutClient')
@section('content')
    <div class="client-main">
        @if(isset($client))
            <aside class="client-aside">

                <div class="client-aside__avatar">
                    <img class="settings-block__avatar"
                         src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}" alt="">
                    <div class="client-aside__mess">{{trans('client_site.hello')}}, {{ $client->first_name }}!</div>
                </div>

                <ul class="client-aside__list">
                    <li class="client-aside__item"><a href="/client/settings">{{trans('common.config')}}</a></li>
                    <li class="client-aside__item"><a href="/client/newsletter">{{trans('common.newsletter')}}</a></li>
                    <li class="client-aside__item"><a href="/client/logout">{{trans('layout.logout')}}</a></li>
                </ul>

            </aside>
        @else

            <aside class="client-aside">
                <div class="auth__container">
                    <auth-form></auth-form>
                </div>
            </aside>



        @endif
        <div class="client-content">

            <section class="client-about">
                <h1 class="client-about__heading">{{trans('client_site.about_us')}}</h1>
                <pre class="client-about__text">{{{isset($about_us) ? $about_us : ''}}}</pre>
            </section>

        </div>
    </div>
    <template id="auth-form-tpl">
    <form action="/client/check" method="post" id="loginForm" v-if="showLogin">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input class="login-form__input login-form__input--email" type="text" name="email"
               placeholder="Ihre E-Mail">
        <input class="login-form__input login-form__input--pass" type="password" name="password"
               placeholder="Password">
        <input class="login-form__checkbox" type="checkbox" id="confirm" name="confirm">
        <label for="confirm">{{trans('client_site.stay_in_system')}}</label>
        <input class="login-form__submit" type="submit" value="{{trans('client_site.login')}}">

        <div>
            <a href="/client/registration">{{trans('client_site.registration')}}</a>
            <span>&middot;</span>
            <a href @click.prevent="showRestoreForm">{{trans('client_site.forgot_password')}}</a>
        </div>
    </form>
    <form action="forgotpass" v-if="showRestore" @submit.prevent="restorePassword" >
        <div class="auth-restore-form clearfix">
            <p v-if="invalidEmailRestore">{{trans('client_site.message_wrong_email')}}</p>
            <p v-if="validEmailRestore">{{trans('client_site.message_new_password_send')}}</p>
            <div class="auth-restore-form__inputs">
                <input type="email" name="forgotpass" id="forgotpass" class="login-form__input" v-model="restoreEmail" placeholder="E-mail">

            </div>
            <div class="sk-fading-circle" v-if="restoringPass">
                <div class="sk-circle1 sk-circle"></div>
                <div class="sk-circle2 sk-circle"></div>
                <div class="sk-circle3 sk-circle"></div>
                <div class="sk-circle4 sk-circle"></div>
                <div class="sk-circle5 sk-circle"></div>
                <div class="sk-circle6 sk-circle"></div>
                <div class="sk-circle7 sk-circle"></div>
                <div class="sk-circle8 sk-circle"></div>
                <div class="sk-circle9 sk-circle"></div>
                <div class="sk-circle10 sk-circle"></div>
                <div class="sk-circle11 sk-circle"></div>
                <div class="sk-circle12 sk-circle"></div>
            </div>
            <div class="auth-restore-form__actions">
                <input type="submit" class="login-form__restore fl"
                       value="{{trans('client_site.restore')}}"
                       :disabled="restoringPass">
                <a href @click.prevent="hideRestoreForm" class="fr">{{trans('client_site.back')}}</a>
            </div>
        </div>
    </form>
</template>
@stop

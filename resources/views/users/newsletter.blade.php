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
            <form action="/client/newsletter/edit" method="post">
                {{csrf_field()}}
            <section class="client-newsletter">
                <h1 class="client-newsletter__heading">{{trans('common.newsletter')}}</h1>
                <ul class="client-newsletter__list">
                    @if($subscribe)
                        @foreach($subscribe as $s)
                            <li class="client-newsletter__item">
                                <table class="newsletter-table">
                                    <tr>
                                        <td><img src="{{isset($s->firm_logo) ? $s->firm_logo : asset('images/default_logo.png')}}" alt=""
                                                 class="newsletter-table__avatar"></td>
                                        <td>
                                            <h2 class="newsletter-table__heading">{{$s->firmlink}}.timebox24.com</h2>
                                        </td>

                                        <td>
                                            <input class="newsletter-table__checkbox" name="subscribe[]" value="{{$s->admin_id}}"
                                                   type="checkbox"
                                                    @if($s->email_send)
                                                        checked
                                                    @endif
                                            >
                                        </td>
                                    </tr>
                                </table>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <button class="client-newsletter__btn btn btn--red" type="submit">{{trans('common.save')}}</button>
            </section>
            </form>
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

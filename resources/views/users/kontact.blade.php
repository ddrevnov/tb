@extends('layouts.layoutClient')
@section('content')
    <div class="client-main">
        @if(isset($client))
            <aside class="client-aside">

                <div class="client-aside__avatar">
                    <img class="settings-block__avatar" src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}" alt="">
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
            <section class="client-kontakt">
                <h1 class="client-kontakt__heading">{{trans('client_site.contacts')}}</h1>
                <div class="client-kontakt__map" id="googleMap"
                     data-country="{{isset($firm_details->country) ? '' : ''}}"
                     data-city="{{isset($firm_details->city) ? '' : ''}}"
                     data-street="{{isset($firm_details->street) ? '' : ''}}"></div>

                <div class="kontakt-tabs" id="kontaktTabs">
                    <ul class="kontakt-tabs__list">
                        <li class="kontakt-tabs__item"><a class="kontakt-tabs__link" href="#tabs-1">{{trans('client_site.contact_data')}}</a></li>
                        <li class="kontakt-tabs__item"><a class="kontakt-tabs__link" href="#tabs-2">{{trans('client_site.address')}}</a></li>
                        <li class="kontakt-tabs__item"><a class="kontakt-tabs__link" href="#tabs-3">{{trans('client_site.work_times')}}</a></li>
                    </ul>
                    <div class="kontakt-tabs__tab" id="tabs-1">
                        <ul>
                            <li>Tel: <span>{{isset($firm_details->firm_telnumber) ? $firm_details->firm_telnumber : ''}}</span></li>
                            <li>Email: <span>{{isset($admin_details->email) ? $admin_details->email : ''}}</span></li>
                            <li>Web: <span>{{isset($admin_details->firmname) ? $admin_details->firmname : ''}}</span></li>
                        </ul>
                    </div>
                    <div class="kontakt-tabs__tab" id="tabs-2">
                        <ul>
                            <li>{{trans('client_site.firm_name')}}: {{isset($firm_details->firm_name) ? $firm_details->firm_name : ''}}</li>
                            <li>{{trans('common.street')}}: {{isset($firm_details->street) ? $firm_details->street : ''}}</li>
                            <li>{{trans('common.post_index')}}: {{isset($firm_details->post_index) ? $firm_details->post_index : ''}}</li>
                            <li>{{trans('common.city')}}: {{isset($firm_details->city) ? $firm_details->city : ''}}</li>
                            <li>{{trans('common.country')}}: {{isset($firm_details->country) ? $firm_details->country : ''}}</li>
                        </ul>
                    </div>
                    <div class="kontakt-tabs__tab" id="tabs-3">

                        <table>
                            @if($firmShedule->count() > 0)
                            @for($i = 0; $i < 7; $i++)
                            <tr data-index-day="{{$i}}" class="worktime-tr">
                                <th>{{$days[$i]}}:</th>
                                <td>
                                    <span class="td-data">{{(isset($firmShedule[$i]['from']) and $firmShedule[$i]['from'] != "00:00:00") ? (new \DateTime($firmShedule[$i]['from']))->format('H:i') : ''}}</span>
                                    <span>{{(isset($firmShedule[$i]['from']) and $firmShedule[$i]['from'] != "00:00:00") ? ' - ' : ''}}</span>
                                    <span class="td-data">
                                        {{(isset($firmShedule[$i]['to']) and $firmShedule[$i]['to'] != "00:00:00") ?
                                        (new \DateTime($firmShedule[$i]['to']))->format('H:i') : trans('common.close')}}</span>
                                </td>
                            </tr>
                            @endfor
                            @endif
                        </table>
                    </div>
                </div>

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

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
            {{--@include('layouts.loginform')--}}
            @yield('login')
            <tabs></tabs>
        </div>
    </div>
    <template id="tabs-tpl">
        <section class="client-booking">
            <div class="booking-tabs" id="bookingTabs">
                <ul class="booking-tabs__list nav-wizard">
                    <li class="booking-tabs__item">
                        <a class="booking-tabs__link" href="#bookingTabs-1">{{trans_choice('common.services', 2)}}</a>

                        <div class="nav-arrow"></div>
                    </li>
                    <li class="booking-tabs__item">
                        <div class="nav-wedge"></div>
                        <a class="booking-tabs__link" href="#bookingTabs-2">{{trans_choice('common.employees', 2)}}</a>

                        <div class="nav-arrow"></div>
                    </li>
                    <li class="booking-tabs__item">
                        <div class="nav-wedge"></div>
                        <a class="booking-tabs__link" href="#bookingTabs-3">{{trans('common.date')}}</a>

                        <div class="nav-arrow"></div>
                    </li>
                    <!--<li class="booking-tabs__item">-->
                    <!--<div class="nav-wedge"></div>-->
                    <!--<a class="booking-tabs__link" href="#bookingTabs-4">Zeit</a>-->

                    <!--<div class="nav-arrow"></div>-->
                    <!--</li>-->
                    <li class="booking-tabs__item">
                        <div class="nav-wedge"></div>
                        <a class="booking-tabs__link" href="#bookingTabs-5"><i class="booking-tabs__ok"></i></a></li>
                </ul>

                <div class="booking-tabs__tab" id="bookingTabs-1">
                    <div class="booking-accordion" id="bookingAccordion">
                        @foreach ($categoryList as $category)
                            <h3 class="booking-accordion__heading">{{$category->category_name}}</h3>
                            <table class="booking-table">
                                @foreach ($servicesList as $service)
                                    @if($category->category_name == $service->category_name)

                                        <tr data-service-id="{{$service->id}}"
                                            data-service-dur="{{$service->duration}}"
                                            data-service-title="{{$service->service_name}}"
                                            data-service-descr="{{$service->description}}"
                                            data-service-price="{{$service->price}}">
                                            <td>
                                                <h4 class="booking-table__name">{{$service->service_name}}</h4>

                                            <!--<p class="booking-table__text">{{$service->description}}</p>-->
                                            </td>
                                            <td>
                                                <?php
                                                $h = floor($service->duration / 60);
                                                $m = $service->duration % 60;
                                                if ($h != 0)
                                                    printf("%d h:%02d min", $h, $m);
                                                else
                                                    printf("%02d min", $m);
                                                ?>
                                            </td>
                                            <td>{{$service->price}} EUR</td>
                                            <td>
                                                <button class="booking-table__btn btn btn--red"
                                                        @click.prevent="toBook($event)">
                                                    {{trans('client_site.book')}}
                                                </button>
                                            </td>
                                        </tr>

                                    @endif
                                @endforeach
                            </table>
                        @endforeach
                    </div>
                </div>
                <div class="booking-tabs__tab" id="bookingTabs-2">
                    <ul class="mitarbeiter">

                        @foreach($employees as $employee)
                            <li class="mitarbeiter__item"
                                data-employee-id="{{$employee->id}}"
                                data-employee-name="{{$employee->name}}"
                                data-employee-avatar="{{isset($employee->path) ? $employee->path : asset('images/default_avatar.png') }}"
                                @click.prevent="selectEmployee($event)">
                                <a href="#">
                                    <img src="{{isset($employee->path) ? $employee->path : asset('images/default_avatar.png') }}"
                                         alt="" class="mitarbeiter__img">
                                </a>

                                <div class="mitarbeiter__name">{{$employee->name}}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="booking-tabs__tab" id="bookingTabs-3">
                    <div class="booking-date" id="bookingDatepicker"></div>
                    <div class="times">
                        <h4 class="times__heading">Wählen Sie eine Zeit</h4>
                            <ul class="times__list">

                                <li
                                    @click="setOrderTime(time, $event)"
                                    v-for="time in times" class="times__item">
                                    @{{ time }}
                                </li>

                            </ul>
                        <div class="no-availability" style="display: none;">
                            Keine Zeiten für das ausgewählte Datum verfügbar
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="booking-tabs__tab" id="bookingTabs-5">
                    <div class="booking-ok">
                        <h2 class="booking-ok__heading">{{trans('client_site.message_check_details')}}</h2>

                        <div>
                            <div class="booking-ok__avatar">
                                <img :src="order.employeeAvatar" alt="" class="booking-ok__img">

                                <div class="booking-ok__name">@{{ order.employeeName }}</div>
                            </div>
                            <ul class="booking-ok__data">
                                <li>{{trans('common.date')}}: <span>@{{ order.date }}</span></li>
                                <li>{{trans('common.time')}}: <span>@{{ order.timeFrom }}</span></li>
                                <li>{{trans('client_site.where')}}:
                                    <span>  {{isset($firm_details->street) ? $firm_details->street : ''}}
                                        {{isset($firm_details->post_index) ? $firm_details->post_index : ''}}
                                </span>
                                </li>
                            </ul>
                        </div>
                        <table class="booking-ok__table booking-table">
                            <tr>
                                <td>
                                    <h4 class="booking-table__name">@{{ order.serviceTitle }}</h4>

                                    <p class="booking-table__text">@{{ order.serviceDescr }}</p>
                                </td>
                                <td>@{{ order.duration }}</td>
                                <td>@{{ order.servicePrice }} EUR</td>
                            </tr>
                        </table>
                        <div class="booking-ok__reg-form">
                            @if(!isset($client))
                                <form id="guestForm" action="">
                                    <input type="text" class="login-form__input" name="first_name"
                                           placeholder="First name"
                                           v-model="order.guest.firstName" required>
                                    <input type="text" class="login-form__input" name="last_name"
                                           placeholder="Last name"
                                           v-model="order.guest.lastName" required>
                                    <input type="text" class="login-form__input" name="mobile" placeholder="Mobile"
                                           v-model="order.guest.mobile" required>
                                    <input type="text" class="login-form__input" name="email" placeholder="E-mail"
                                           v-model="order.guest.email" required>
                                </form>
                            @endif
                        </div>
                        <div class="booking-ok__price">
                            <div class="booking-ok__sum">
                                {{trans('client_site.total_sum')}}: <span>@{{ order.servicePrice }} EUR</span>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-around;">
                                <p>Send sms</p>
                                <input type="checkbox"
                                       name="sms"
                                       v-model="order.sms"
                                       :true-value="1"
                                       :false-value="0">
	                            <p>Send email</p>
	                            <input type="checkbox"
	                                   name="email"
	                                   v-model="order.email"
	                                   :true-value="1"
	                                   :false-value="0">
                            </div>
                            <button class="btn btn--green"
                                    :disabled="sendingOrder"
                            @click="sendOrder">{{trans('client_site.confirm_order')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="booking__next-box">
            <button class="booking-table__btn btn btn--red" id="nextStep"
                    v-if="showNextStepBtn"
                    :disabled="!isEnabledNextBtn"
                    @click.prevent="toNextTab">{{trans('client_site.next_step')}}
            </button>
        </div>

        <div class="remodal"
             data-remodal-id="modal-order-success">
            <h1>{{trans('client_site.message_order_save')}}</h1>

            <p>
                {{trans('client_site.message_in_future_employees_contact')}}
            </p>
            <br>
            <button class="remodal-confirm btn--red"
            @click="closeModal">{{trans('client_site.close')}}
            </button>
        </div>
        <div class="remodal"
             data-remodal-id="modal-login">
            <h1>{{trans('client_site.warning')}}</h1>

            <p>
                {{trans('client_site.message_error_need_registration')}} <a
                        href="/client/registration">{{trans('client_site.registration')}}</a>
            </p>
            <br>
            <button class="remodal-confirm btn--red"
            @click="closeModalLogin">{{trans('client_site.close')}}
            </button>
        </div>
    </template>
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
        <form action="forgotpass" v-if="showRestore" @submit.prevent="restorePassword">
            <div class="auth-restore-form clearfix">
                <p v-if="invalidEmailRestore">{{trans('client_site.message_wrong_email')}}</p>
                <p v-if="validEmailRestore">{{trans('client_site.message_new_password_send')}}</p>
                <div class="auth-restore-form__inputs">
                    <input type="email" name="forgotpass" id="forgotpass" class="login-form__input"
                           v-model="restoreEmail" placeholder="E-mail">

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

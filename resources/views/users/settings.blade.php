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

        <section class="client-settings">
            <h1 class="client-settings__h1">{{trans('common.config')}}</h1>

            <h2 class="client-settings__h2">{{trans('common.avatar')}}</h2>

            <div class="settings-block settings-block--avatar">
                <img class="settings-block__avatar"
                     src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}" alt="">

                <form method="post" action="change_avatar" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="file" name="avatar">
                    <button type="submit" href="" class="settings-block__btn btn btn--red">{{trans('common.change')}}</button>
                </form>

            </div>

            <h2 class="client-settings__h2">{{trans('common.personal_info')}}</h2>

            <form action="update" method="POST">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <div class="settings-block">
                    <table class="settings-block__table">
                        <tr>
                            <th>{{trans('common.gender')}}:</th>
                            <td>{{ isset($client->gender) ? $client->gender : '' }}</td>
                            <td><a href="#" class="settings-block__btn btn btn--red">{{trans('common.change')}}</a></td>
                        </tr>
                    </table>
                    <table class="settings-block__table settings-block__form">
                        <tr>
                            <th>{{trans('common.gender')}}:</th>
                            <td>
                                <select name="gender">
                                    <option value="man">{{trans('common.male')}}</option>
                                    <option value="woman">{{trans('common.female')}}</option>
                                </select>
                            </td>
                            <td rowspan="2"><input type="submit" class="settings-block__btn btn btn--red" value="{{trans('common.change')}}"></td>
                        </tr>
                    </table>
                </div>

                <div class="settings-block">
                    <table class="settings-block__table">
                        <tr>
                            <th>{{trans('common.first_name')}}:</th>
                            <td>{{ isset($client->first_name) ? $client->first_name : '' }}</td>
                            <td rowspan="2"><a href="#" class="settings-block__btn btn btn--red">{{trans('common.change')}}</a></td>
                        </tr>
                        <tr>
                            <th>{{trans('common.last_name')}}</th>
                            <td>{{ isset($client->last_name) ? $client->last_name : '' }}</td>
                        </tr>
                    </table>
                    <table class="settings-block__table settings-block__form">
                        <tr>
                            <th>{{trans('common.first_name')}}:</th>
                            <td><input name="first_name" type="text"
                                       value="{{ isset($client->first_name) ? $client->first_name : '' }}"></td>
                            <td rowspan="2"><input type="submit" class="settings-block__btn btn btn--red"
                                                   value="{{trans('common.change')}}"></td>
                        </tr>
                        <tr>
                            <th>{{trans('common.last_name')}}</th>
                            <td><input name="last_name" type="text"
                                       value="{{ isset($client->last_name) ? $client->last_name : '' }}"></td>
                        </tr>
                    </table>
                </div>

                <div class="settings-block">
                    <table class="settings-block__table">
                        <tr>
                            <th>{{trans('common.telephone')}}:</th>
                            <td>{{ isset($client->telephone) ? $client->telephone : '' }}</td>
                            <td rowspan="3"><a href="#" class="settings-block__btn btn btn--red">{{trans('common.change')}}</a></td>
                        </tr>
                        <tr>
                            <th>{{trans('common.mobile')}}:</th>
                            <td>{{ isset($client->mobile) ? $client->mobile : '' }}</td>
                        </tr>
                        <tr>
                            <th>{{trans('common.e-mail')}}:</th>
                            <td>{{ isset($client->email) ? $client->email : '' }}</td>
                        </tr>
                    </table>
                    <table class="settings-block__table settings-block__form">
                        <tr>
                            <th>{{trans('common.telephone')}}:</th>
                            <td><input name="telephone" type="tel"
                                       value="{{ isset($client->telephone) ? $client->telephone : '' }}"></td>
                            <td rowspan="3"><input type="submit" class="settings-block__btn btn btn--red"
                                                   value="{{trans('common.change')}}"></td>
                        </tr>
                        <tr>
                            <th>{{trans('common.mobile')}}:</th>
                            <td><input name="mobile" type="tel"
                                       value="{{ isset($client->mobile) ? $client->mobile : '' }}"></td>
                        </tr>
                        <tr>
                            <th>{{trans('common.e-mail')}}:</th>
                            <td><input name="" type="email"
                                       value="{{ isset($client->email) ? $client->email : '' }}"></td>
                        </tr>

                    </table>
                </div>

                <div class="settings-block">
                    <table class="settings-block__table">
                        <tr>
                            <th>{{trans('common.birthday')}}:</th>
                            <td>
                                {{ isset($client->birthday) ? $client->birthday : ''}}
                            </td>
                            <td><a href="#" class="settings-block__btn btn btn--red">{{trans('common.change')}}</a></td>
                        </tr>
                    </table>
                    <table class="settings-block__table settings-block__form">
                        <tr>
                            <th>{{trans('common.birthday')}}:</th>
                            <td>
                                <input name="birthday" id="birthday"
                                       value="{{ isset($client->birthday) ? $client->birthday : '' }}">
                            </td>
                            <td><input type="submit" class="settings-block__btn btn btn--red" value="{{trans('common.change')}}"></td>
                        </tr>
                    </table>
                </div>

                <div class="settings-block">
                    <table class="settings-block__table">
                        <tr>
                            <th>{{trans('common.password')}}:</th>
                            <td></td>
                            <td><a href="#" class="settings-block__btn btn btn--red">{{trans('common.change')}}</a></td>
                        </tr>
                    </table>
                    <table class="settings-block__table settings-block__form">
                        <tr>
                            <th rowspan="2">{{trans('common.password')}}:</th>
                            <td><input name="password" type="password" placeholder="password" id="pass"></td>
                            <td rowspan="2"><input type="submit" class="settings-block__btn btn btn--red"
                                                   value="{{trans('common.change')}}"></td>
                        </tr>
                        <tr>
                            <td><input type="password" placeholder="confirm" id="pass_confirm"></td>
                        </tr>
                    </table>
                </div>
            </form>


        </section>

    </div>
</div>
@stop

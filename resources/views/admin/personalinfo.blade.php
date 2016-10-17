{{--@extends('layouts.layoutAdmin')--}}
{{--@section('content')--}}
    {{--<section class="admin-settings director-main">--}}
        {{--<h1 class="director-content__heading heading heading__h1">Persönliche Daten</h1>--}}

        {{--<div class="director-content">--}}

            {{--<div class="block">--}}
                {{--<ul class="block__nav">--}}
                    {{--<li data-tab="tab-1" class="block__item is-active">Avatar</li>--}}
                    {{--<li data-tab="tab-2" class="block__item">Kontakt Daten</li>--}}
                    {{--<li data-tab="tab-3" class="block__item">Anschrift</li>--}}
                    {{--<li data-tab="tab-4" class="block__item">Password</li>--}}
                {{--</ul>--}}

                {{--<div data-tab-id="tab-1" class="tab-content is-active">--}}
                    {{--<div class="logo-block">--}}
                        {{--<div class="logo-block__box">--}}
                            {{--<a class="logo-block__btn btn btn--gray" href="#">Datei auswählen</a>--}}
                            {{--<form class="logo-block__form" action="/office/storeavatar" method="post" enctype="multipart/form-data">--}}
                                {{--<input class="logo-block__file" name="avatar" type="file" />--}}
                                {{--<input type="hidden" name="_token" value="{!! csrf_token() !!}">--}}
                                {{--<input class="btn btn--gray" type="submit" value="Send File"  id="send-img"/>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                        {{--<div class="logo-block__img">--}}
                            {{--<img src="{{isset($avatar) ? $avatar : asset('images/default_avatar.png') }}" alt="">--}}
                        {{--</div>--}}
                        {{----}}
                        {{--<div class="logo-block__edit"></div>--}}
                        {{--<a class="logo-block__btn btn btn--red" href="#">Speichern</a>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div data-tab-id="tab-2" class="tab-content">--}}
                    {{--<table class="table table--striped">--}}

                        {{--<tr>--}}
                            {{--<td>Telefon</td>--}}
                            {{--<td><span class="td-data">{{{isset($adminInfo->telnumber) ? $adminInfo->telnumber : ''}}}</span>--}}
                                {{--<input class="input-data" id="telnumber"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Mobile</td>--}}
                            {{--<td><span class="td-data">{{{isset($adminInfo->mobile) ? $adminInfo->mobile : ''}}}</span>--}}
                            {{--<input class="input-data" id="mobile"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>E-Mail:</td>--}}
                            {{--<td><span class="td-data">{{{isset($adminInfo->email) ? $adminInfo->email : ''}}}</span>--}}
                            {{--<input class="input-data" id="email"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Skype</td>--}}
                            {{--<td><span class="td-data">{{{isset($adminInfo->skype) ? $adminInfo->skype : ''}}}</span>--}}
                            {{--<input class="input-data" id="skype"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Geschlecht</td>--}}
                            {{--<td><span class="td-data">{{{isset($adminInfo->gender) ? $adminInfo->gender : ''}}}</span>--}}
                            {{--<input class="input-data" id="gender"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                    {{--</table>--}}
                    {{--<a class="director-kunden__btn btn btn--red" href="/office/personalinfo/" id="contact_edit">Jetzt ändern</a>--}}
                {{--</div>--}}

                {{--<div data-tab-id="tab-3" class="tab-content">--}}
                    {{--<table class="table table--striped">--}}

                        {{--<tr>--}}
                            {{--<td>Name</td>--}}
                            {{--<td><span class="td-data-2">{{{isset($adminInfo->firstname) ? $adminInfo->firstname : ''}}}</span>--}}
                            {{--<input class="input-data-2" id="firstname"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Vorname</td>--}}
                            {{--<td><span class="td-data-2">{{{isset($adminInfo->lastname) ? $adminInfo->lastname : ''}}}</span>--}}
                            {{--<input class="input-data-2" id="lastname"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Strasse / Nr</td>--}}
                            {{--<td><span class="td-data-2">{{{isset($adminInfo->street) ? $adminInfo->street : ''}}}</span>--}}
                            {{--<input class="input-data-2" id="street"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>PLZ / Stadt</td>--}}
                            {{--<td><span class="td-data-2">{{{isset($adminInfo->city) ? $adminInfo->city : ''}}}</span>--}}
                            {{--<input class="input-data-2" id="city"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Bundesland</td>--}}
                            {{--<td><span class="td-data-2">{{{isset($adminInfo->state) ? $adminInfo->state : ''}}}</span>--}}
                            {{--<input class="input-data-2" id="state"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Land</td>--}}
                            {{--<td><span class="td-data-2">{{{isset($adminInfo->country) ? $adminInfo->country : ''}}}</span>--}}
                            {{--<input class="input-data-2" id="country"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                    {{--</table>--}}
                    {{--<a class="director-kunden__btn btn btn--red" href="/office/personalinfo/" id="adress_edit">Jetzt ändern</a>--}}
                {{--</div>--}}

                {{--<div data-tab-id="tab-4" class="tab-content">--}}
                    {{--<table class="table table--striped">--}}

                        {{--<tr>--}}
                            {{--<td>Old password</td>--}}
                            {{--<td>--}}
                                {{--<input class="" type="password" id="old_password"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>New password</td>--}}
                            {{--<td>--}}
                                {{--<input class="" type="password" id="new_password-1"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>Repeat new password</td>--}}
                            {{--<td>--}}
                                {{--<input class="" type="password" id="new_password-2"/>--}}
                            {{--</td>--}}
                        {{--</tr>--}}


                    {{--</table>--}}
                    {{--<a class="director-kunden__btn btn btn--red" href="/office/personalinfo/" id="password_edit">Jetzt ändern</a>--}}
                {{--</div>--}}

            {{--</div>--}}

        {{--</div>--}}

    {{--</section>--}}
{{--@stop--}}
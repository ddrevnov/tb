@extends('layouts.layoutDirector')
@section('content')
    <section class="director-mitarbeiter director-main">
        <h1 class="director-content__heading heading heading__h1">Mitarbeiter</h1>
        <form id="userInfoForm" method="post" action="employee_store" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="director-content">
                <section class="user-info">
                    <ul class="user-info__list">

                        <li class="user-info__name">
                            <h2 class="user-info__heading">Avatar</h2>
                            <img src="{{asset('images/default_avatar.png') }}">
                            <div><input type="file" name="avatar"></div>
                        </li>

                        <li class="user-info__name">
                            <h2 class="user-info__heading">Name & Vorname</h2>
                            <div><input type="text" name="name" required></div>
                            <div><input type="text" name="last_name" required></div>
                        </li>

                        <li class="user-info__contact">
                            <h2 class="user-info__heading">Kontact</h2>
                            <div class="user-info__phone"><i></i>
                                <input type="tel" name="phone">
                            </div>
                            <div class="user-info__email"><i></i>
                                <input @blur="checkEmail($event, '/backend/check_email')" type="email" name="email" required>
                            </div>
                        </li>

                        <li class="user-info__data">
                            <h2 class="user-info__heading">Persönliche Daten</h2>
                            <div><strong>Geschlecht:</strong> 
                                <select class="kalendar-form__input kalendar-input" name="gender">
                                <option value="male" selected>Male</option>
                                <option value="female">Female</option>
                            </select>
                            </div>
                            <div><strong>Geburstag:</strong>  
                                <input class="input-date" name="birthday" type="text">
                            </div>
                        </li>

                        <li class="user-info__data">
                            <h2 class="user-info__heading">Status</h2>
                            <div><strong>Group:</strong>
                                <select name="group">
                                    <option value="admin">Admin</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                            <div><strong>Status:</strong>
                                <select name="status">
                                    <option value="active">Active</option>
                                    <option value="not active">Not active</option>
                                </select>
                            </div>
                        </li>


                    </ul>



                </section>

                <section class="director-dienstleister2__main director-mitarbeiter__main">

                    <div class="director-dienstleister2__bottom">
                        <button type="submit" class="btn btn--red">Jetzt ändern</button>
                    </div>
                </section>
            </div>
        </form>
    </section>
@stop
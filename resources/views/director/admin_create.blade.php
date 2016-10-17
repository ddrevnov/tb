@extends('layouts.layoutDirector')
@section('content')
<section class="director-mitarbeiter director-main">
    <h1 class="director-content__heading heading heading__h1">Dienstleister</h1>
    <form id="userInfoForm" method="post" action="new_admin_store" enctype="multipart/form-data">
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
                        <div><input type="text" name="firstname" required></div>
                        <div><input type="text" name="lastname" required></div>
                        <h2 class="user-info__heading">FirmLink</h2>
                        <div><input type="text" name="firmlink" required></div>
                        <h2 class="user-info__heading">Firm Type</h2>
                        <select name="firmtype">
                            @foreach($firmType as $firm)
                            <option value="{{$firm->id}}">{{$firm->firmtype}}</option>
                            @endforeach
                        </select>
                        <h2 class="user-info__heading">Tariff</h2>
                        <select name="tariff">
                            @foreach($tariffs as $tariff)
                                <option value="{{$tariff->id}}">{{$tariff->name}}</option>
                            @endforeach
                        </select>
                    </li>

                    <li class="user-info__contact">
                        <h2 class="user-info__heading">Kontact</h2>
                        <div class="user-info__phone"><i></i> <input type="tel" name="telnumber"></div>
                        <div class="user-info__email"><i></i> 
                        <input @blur="checkEmail($event, '/backend/check_email')" type="email" name="email" required>
                        </div>
                    </li>

                    <li class="user-info__data">
                        <h2 class="user-info__heading">Persönliche Daten</h2>
                        <div><strong>Geschlecht:</strong> 
                            <select name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div><strong>Geburstag:</strong>  
                            <input class="input-date" name="birthday" type="text">
                        </div>
                    </li>

                    <li class="user-info__data">
                        <h2 class="user-info__heading">Status</h2>
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
                    <button type="submit" class="btn btn--red" id="create_new_admin">Create now</button>
                </div>
            </section>
        </div>
    </form>
</section>

@stop
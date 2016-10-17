@extends('layouts.layoutDirector')
@section('content')
<section class="director-dienstleister2 director-main">
    <h1 class="director-content__heading heading heading__h1">Dienstleister</h1>

    <div class="director-content">
        <section class="user-info">
            <ul class="user-info__list">

                <img class="user-info__avatar" src="{{asset('images/default_avatar.png') }}" alt="">

                <li class="user-info__name">
                    <h2 class="user-info__heading">Name & Vorname</h2>
                    <div>{{$newAdminInfo->firstname}} {{$newAdminInfo->lastname}}</div>
                </li>

                <li class="user-info__contact">
                    <h2 class="user-info__heading">Kontact</h2>
                    <div class="user-info__email"><i></i> <span>{{$newAdminInfo->email}}</span></div>
                </li>

                <li class="user-info__data">
                    <h2 class="user-info__heading">Persönliche Daten</h2>
                    <div><strong>Geburstag:</strong>{{$newAdminInfo->firmlink}}</div>
                </li>

                <li class="user-info__data">
                    <h2 class="user-info__heading">Über das UNternehmen</h2>
                    <div><strong>Status:</strong>
                        @if ($newAdminInfo->status == 'new')
                        <select name="status">
                            <option value="delete">Delete</option>
                            <option value="active">Active</option>
                        </select>
                        @else
                        <p>Active</p>
                        @endif
                    </div>
                </li>
            </ul>
        </section>
        <section class="director-dienstleister2__main">
            <div class="director-dienstleister2__bottom" id="chDirectorNewAdmin">
                <a href="#" class="btn btn--red">Jetzt ändern</a>
            </div>
        </section>
    </div>
</section>
@stop
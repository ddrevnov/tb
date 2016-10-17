@extends('layouts.layoutAdmin')
@section('content')
    <section class="director-mitarbeiter director-main">

        <h1 class="director-content__heading heading heading__h1">{{trans_choice('common.clients', 2)}}</h1>
        <form id="userInfoForm" method="post" action="/office/clients/store" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="director-content">

                <section class="user-info">
                    <ul class="user-info__list">
                        {{csrf_field()}}
                        <li class="user-info__name">
                            <h2 class="user-info__heading">{{trans('common.avatar')}}</h2>
                            <img src="{{asset('images/default_avatar.png')}} ">
                            <div><input type="file" name="avatar"></div>
                        </li>

                        <li class="user-info__name">
                            <h2 class="user-info__heading">{{trans('common.first_name')}} {{trans('common.last_name')}}</h2>
                            <div>
                                <input class="user-info__input" type="text" name="name" required>
                                <input class="user-info__input" type="text" name="last_name" required>
                            </div>
                        </li>

                        <li class="user-info__contact">
                            <h2 class="user-info__heading">{{trans('common.contact')}}</h2>
                            <div class="user-info__phone"><i></i> <input class="user-info__input" type="tel" name="mobile"></div>
                            <div class="user-info__email">
                                <i></i>
                                <input
                                        class="user-info__input" type="email" name="email" required>
                            </div>
                        </li>

                        <li class="user-info__data">
                            <h2 class="user-info__heading">{{trans('common.personal_info')}}</h2>
                            <div><strong>{{trans('common.gender')}}</strong>
                                <select name="gender">
                                    <option value="male" selected>{{trans('common.male')}}</option>
                                    <option value="female">{{trans('common.female')}}</option>
                                </select>
                            </div>
                            <div><strong>{{trans('common.birthday')}}</strong>
                                <input class="user-info__input input-date" name="birthday" type="text">
                            </div>
                        </li>

                    </ul>
                </section>

                <section class="director-dienstleister2__main director-mitarbeiter__main">

                    <div class="director-dienstleister2__bottom">
                        <button type="submit" class="btn btn--red">{{trans('common.create')}}</button>
                    </div>
                </section>
            </div>
        </form>
    </section>

@stop
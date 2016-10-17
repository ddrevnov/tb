@extends('layouts.layoutAdmin')
@section('content')
    <section class="director-mitarbeiter director-main">
        <alert
                :show.sync="showCreateEmplAlert"
                :duration="3000"
                type="danger"
                width="400px"
                placement="top-right"
                dismissable
        >
            <span class="icon-ok-circled alert-icon-float-left"></span>
            <strong>Error</strong>
            <p>Sie können nicht einen anderen Mitarbeiter erstellen.</p>
        </alert>
        <h1 class="director-content__heading heading heading__h1">{{trans_choice('common.employees', 2)}}</h1>
        <form @submit.prevent="submitCreateEmpl" id="userInfoForm" method="post" action="store" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="director-content">

                <user-info-vue></user-info-vue>

                <section class="director-dienstleister2__main director-mitarbeiter__main">

                    <table class="table table--striped">

                        <tr>
                            <th>{{trans('common.nr')}}</th>
                            <th>{{trans_choice('common.services', 1)}}</th>
                            <th>{{trans('common.status')}}</th>
                        </tr>
                        <?php $i = 1?>
                        @foreach($services as $service)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $service->service_name }}</td>
                                <td><input class="checkbox" type="checkbox" name="services[]"
                                           value="{{ $service->id }}"></td>
                            </tr>
                            <?php $i++?>
                        @endforeach
                    </table>

                    <div class="director-dienstleister2__bottom">
                        <button type="submit" class="btn btn--red">{{trans('common.create')}}</button>
                    </div>
                </section>
            </div>
        </form>
    </section>

    <template id="user-info-template">
        <section class="user-info">
            <ul class="user-info__list">


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
                    <div class="user-info__phone"><i></i> <input class="user-info__input" type="tel" name="phone"></div>
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

                <li class="user-info__data">
                    <h2 class="user-info__heading">{{trans('common.status')}}</h2>
                    <div><strong>Group:</strong>
                        <select name="group">
                            <option value="admin">{{trans('employees.admin')}}</option>
                            <option value="employee">{{trans('employees.employee')}}</option>
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
    </template>
@stop
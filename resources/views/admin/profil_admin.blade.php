@extends('layouts.layoutAdmin')
@section('content')
@include('remodals.profil_admin_remodal')

    <section class="director-mitarbeiter director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans('common.profil')}}</h1>

        <!-- <editing-modal-vue :who="'office'"></editing-modal-vue> -->

        <div class="director-content">

            <user-info-vue></user-info-vue>
           
            @if(isset($employee_services))
                <section class="director-dienstleister2__main director-mitarbeiter__main" id="empl-to-admin-section">
                    <form action="/office/profil_admin/edit_services" method="post">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <table class="table table--striped" id="profil-services-table">
                            <thead>
                            <tr>
                                <th>{{trans('common.nr')}}</th>
                                <th>{{trans_choice('common.services', 2)}}</th>
                                <th>{{trans('common.status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1?>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $service->service_name }}</td>
                                    <td><input class="checkbox" type="checkbox" name="services[]"
                                               value="{{ $service->service_id }}"
                                               @if(in_array($service->service_id,$employee_services))
                                               checked
                                                @endif></td>
                                </tr>
                                <?php $i++?>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="director-dienstleister2__bottom">
                            <input type="submit" class="btn btn--red" value="{{trans('common.save')}}">
                        </div>

                </section>
            @endif

            <section class="director-dienstleister2__main director-mitarbeiter__main" id="admin-to-empl-section">
                <form action="/office/profil_admin/to_employee" method="post">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <table class="table table--striped" id="profil-services-table">
                        <thead>
                        <tr>
                            <th>{{trans('common.nr')}}</th>
                            <th>{{trans_choice('common.services', 2)}}</th>
                            <th>{{trans('common.status')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1?>
                        @foreach($services as $service)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $service->service_name }}</td>
                                <td><input class="checkbox" type="checkbox" name="services[]"
                                           value="{{ $service->service_id }}"
                                </td>
                            </tr>
                            <?php $i++?>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="director-dienstleister2__bottom">
                        <input type="submit" class="btn btn--red" value="{{trans('common.save')}}">
                    </div>
                </form>
            </section>

        </div>
    </section>

    <template id="user-info-template">
    <editing-modal-vue></editing-modal-vue>
        <section class="user-info">
                <ul class="user-info__list">

                <div 
                @click="logoShow = true"
                class="user-info__block-img">
                    <div v-show="showImgPreloader" class="user-info__preloader">
                        <i></i>
                    </div>
                    <img class="user-info__avatar"
                         src="{{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}}" alt="">
                </div>

                <div>
                    <button
                    v-show="logoShow"
                    @click="logoShow = !logoShow"
                    class="user-info__btn btn btn--red">{{trans('common.do_not_change')}}
                    </button>

                    <form
                     @submit.prevent="sendAvatar($event)"
                     v-show="logoShow"
                     class="logo-block__form" action="/office/profil_admin/store_avatar" method="post" enctype="multipart/form-data">
                        <button @click.stop.prevent="changeLogo" class="btn btn--green">{{trans('common.change_avatar')}}</button>
                        <input id="changeLogo" class="logo-block__file logo-block__file--hide" name="avatar" type="file" />
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input class="btn btn--gray" type="submit" value="{{trans('common.send')}}" id="send-avatar"/>
                    </form> 
                </div>

                    <li class="user-info__name">
                        <h2 class="user-info__heading">{{trans('common.first_name')}} {{trans('common.last_name')}}</h2>
                        <div>   {{isset($admin->firstname) ? $admin->firstname : '' }}
                                {{isset($admin->lastname) ? $admin->lastname : ''}}
                                {{isset($admin->name) ? $admin->name : ''}}
                                {{isset($admin->last_name) ? $admin->last_name : ''}}
                        </div>
                    </li>

                     @if(isset($mainAdmin))
                    @if(!isset($employee_services))
                        <li class="user-info__name">
                            <h2 class="user-info__heading">{{trans('common.be_employee')}}</h2>
                            <div>
                                <button class="btn btn--red" id="admin-to-empl">{{trans('common.be_employee')}}</button>
                            </div>
                        </li>
                    @else
                        <li class="user-info__name">
                            <h2 class="user-info__heading">{{trans('common.be_admin')}}</h2>
                            <div>
                                <button class="btn btn--red" id="empl-to-admin">{{trans('common.be_admin')}}</button>
                            </div>
                        </li>
                    @endif
                    @endif

                    <li class="user-info__contact">
                        <h2 class="user-info__heading">{{trans('common.contact')}}</h2>
                        <div class="user-info__phone"><i></i>
                                <span>
                                    {{isset($admin->mobile) ? $admin->mobile : ''}}
                                    {{isset($admin->phone) ? $admin->phone  : ''}}
                                </span>
                        </div>
                        <div class="user-info__email"><i></i>
                                <span>
                                    {{isset($admin->email) ? $admin->email : '' }}
                                </span>
                        </div>
                    </li>

                    <li class="user-info__data">
                        <h2 class="user-info__heading">{{trans('common.personal_info')}}</h2>
                        <div><strong>{{trans('common.gender')}}:</strong>
                            {{isset($admin->gender) ? $admin->gender : '' }}
                        </div>
                        <div><strong>{{trans('common.birthday')}}:</strong>
                            {{isset($admin->birthday) ? $admin->birthday : '' }}
                        </div>


                        <div>
                            <button class="btn btn--red" id="" @click="openUserInfoModal">{{trans('common.change_personal_info')}}</button>
                        </div>

                    </li>
                </ul>
            </section>
    </template>



@stop

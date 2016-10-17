@extends('layouts.layoutAdmin')
@section('content')
@include('remodals.empl_info_remodal')
    <section class="director-mitarbeiter director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans_choice('common.employees', 1)}}</h1>

        <div class="director-content">

        <user-info-vue></user-info-vue>

            <section class="director-dienstleister2__main director-mitarbeiter__main">
                <form action="/office/employees/update_services/{{ $employee->id }}" method="post">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <table class="table table--striped" id="profil-services-table">
                    <thead>
                        <tr><th>{{trans('common.nr')}}</th>
                            <th>{{trans_choice('common.services', 1)}}</th>
                            <th>{{trans('common.status')}}</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $i = 1?>
                        @foreach($services as $service)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $service->service_name }}</td>
                                <td><input class="checkbox" type="checkbox" name="services[]" value="{{ $service->id }}"
                                           @if(in_array($service->id,$employee_services))
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
                </form>
            </section>
        </div>

    </section>

    <template id="user-info-template">
        <alert
                :show.sync="showAvatarSuccess"
                :duration="3000"
                type="success"
                width="400px"
                placement="top-right"
                dismissable
        >
            <span class="icon-ok-circled alert-icon-float-left"></span>
            <strong>{{trans('common.well_done')}}</strong>
            <p>{{trans('common.avatar_error')}}</p>
        </alert>
    <editing-modal-vue></editing-modal-vue>
        <section class="user-info">
                <ul class="user-info__list">

                <div 
                @click="logoShow = true"
                class="user-info__block-img">
                    <div v-show="showImgPreloader" class="user-info__preloader">
                        <i></i>
                    </div>
                    <div class="crops"></div>
                  <img class="user-info__avatar" src="{{{isset($employee->avatarEmployee) ? $employee->avatarEmployee->path : asset('images/default_avatar.png') }}}" alt="">
                </div>

                <div>
                    <button
                    v-show="logoShow"
                    @click.prevent="logoShow = !logoShow"
                    class="user-info__btn btn btn--red">{{trans('common.do_not_change')}}</button>

                    <form
                     @submit.prevent="sendAvatar($event)"
                     v-show="logoShow"
                     class="logo-block__form" method="post" enctype="multipart/form-data"
                     action="/office/employees/info/{{$employee->id}}/store_avatar">
                        <button @click.prevent.stop="changeAvatar" class="btn btn--green">{{trans('common.change_avatar')}}</button>
                        <input @change.stop.prevent="selectFile($event)" id="changeAvatar" class="logo-block__file logo-block__file--hide" name="avatar" type="file" />
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input class="btn btn--gray" type="submit" value="{{trans('common.send')}}" id=""/>
                    </form> 
                </div>
                    
                    <form action="/office/">
                    <li class="user-info__name">
                        <h2 class="user-info__heading">{{trans('common.first_name')}} {{trans('common.last_name')}}</h2>
                        <div>{{ $employee->name }}</div>
                        <div>{{$employee->last_name}}</div>
                    </li>

                    <li class="user-info__contact">
                        <h2 class="user-info__heading">{{trans('common.contact')}}</h2>
                        <div class="user-info__phone"><i></i> <span>{{ $employee->phone }}</span></div>
                        <div class="user-info__email"><i></i> <span>{{ $employee->email }}</span></div>
                    </li>

                    <li class="user-info__data">
                        <h2 class="user-info__heading">{{trans('common.personal_info')}}</h2>
                        <div><strong>{{trans('common.gender')}}:</strong> {{ trans('common.'. $employee->gender) }}</div>
                        <div><strong>{{trans('common.birthday')}}:</strong>  {{ $employee->birthday }}</div>
                    </li>


                    <li class="user-info__data">
                        @can('admin')
                        <h2 class="user-info__heading">{{trans('common.status')}}</h2>
                        <div><strong>{{trans('common.group')}}:</strong>
                            <p>{{trans('employees.'. $employee->group)}}</p>
                        </div>
                        <div><strong>{{trans('common.status')}}:</strong>
                            <p>{{$employee->status}}</p>
                        </div>
                        @endcan

                            <a href="javascript:void(0);" class="btn btn--red" @click="openUserInfoModal">{{trans('common.edit')}}</a>
                    </li>

                </ul>

            </section>
    </template>

    @stop

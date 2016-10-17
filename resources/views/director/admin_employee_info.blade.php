@extends('layouts.layoutDirector')
@section('content')
@include('remodals.empl_info_remodal')
    <section class="director-mitarbeiter director-main">
        <h1 class="director-content__heading heading heading__h1">Mitarbeiter</h1>

        

        <div class="director-content">

        <user-info-vue></user-info-vue>

            <section class="director-dienstleister2__main director-mitarbeiter__main">
                <form action="/backend/admins/edit_employee/{{ $employee->id }}/update_services" method="post">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <table class="table table--striped" id="profil-services-table">
                    <thead>
                        <tr><th>Nr:</th>
                            <th>Leistung</th>
                            <th>Status</th>
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
                        <input type="submit" class="btn btn--red" value="Jetzt ändern">
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
            <strong>Well Done!</strong>
            <p>Avatar es verändert wurde</p>
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
                  <img class="user-info__avatar" v-show="!isSetAvatar"
                       src="{{isset($employee->avatarEmployee) ? $employee->avatarEmployee->path : asset('images/default_avatar.png') }}" alt="">
                </div>

                <div>
                    <button
                    v-show="logoShow"
                    @click="cancelSetAvatar"
                    class="user-info__btn btn btn--red">
                        @{{ logoShow ? 'Do not change' : 'Change' }}
                    </button>

                    <form @submit.prevent="setAvatar({{$employee->id}})"
                     v-show="logoShow"
                     class="logo-block__form" method="post" enctype="multipart/form-data"
                     action="/backend/admins/edit_employee/{{$employee->id}}/store_avatar">
                        <button @click.prevent.stop="changeAvatar" class="btn btn--green">Change avatar</button>
                        <input id="changeAvatar" class="logo-block__file logo-block__file--hide" name="avatar" type="file" @change="selectFile"/>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input class="btn btn--gray" type="submit" value="Send File" id=""/>
                    </form> 
                </div>
                    
                    <form action="/backend/">
                    <li class="user-info__name">
                        <h2 class="user-info__heading">Name & Vorname</h2>
                        <div>{{ $employee->name }}</div>
                        <div>{{$employee->last_name}}</div>
                    </li>

                    <li class="user-info__contact">
                        <h2 class="user-info__heading">Kontact</h2>
                        <div class="user-info__phone"><i></i> <span>{{ $employee->phone }}</span></div>
                        <div class="user-info__email"><i></i> <span>{{ $employee->email }}</span></div>
                    </li>

                    <li class="user-info__data">
                        <h2 class="user-info__heading">Persönliche Daten</h2>
                        <div><strong>Geschlecht:</strong> {{ $employee->gender }}</div>
                        <div><strong>Geburstag:</strong>  {{ $employee->birthday }}</div>
                    </li>


                    <li class="user-info__data">

                        <h2 class="user-info__heading">Status</h2>
                        <div><strong>Group:</strong>
                            <p>{{$employee->group}}</p>
                        </div>
                        <div><strong>Status:</strong>
                            <p>{{$employee->status}}</p>
                        </div>

                            <a href="javascript:void(0);" class="btn btn--red" @click="openUserInfoModal">Jetzt ändern</a>
                    </li>

                </ul>

            </section>
    </template>

    @stop

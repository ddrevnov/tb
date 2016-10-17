@extends('layouts.layoutDirector')
@section('content')
@include('remodals.personal_info_remodal')
    <section class="director-dienstleister2 director-main">
        <h1 class="director-content__heading heading heading__h1">Direktor</h1>

        <div class="director-content">

          <user-info-vue></user-info-vue>

            <section class="director-dienstleister2__main">
                <div class="director-dienstleister2__bottom">
                    
                </div>
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
            <p>Avatar wurde geändert.</p>
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
                  <img class="user-info__avatar" v-show="!isSetAvatar" src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}" alt="">
                </div>
                <div>
                    <button
                    v-show="logoShow"
                    @click="cancelSetAvatar"
                    class="user-info__btn btn btn--red">
                        @{{ logoShow ? 'Do not change' : 'Change' }}
                    </button>

                    <form @submit.prevent="setAvatar()"
                     v-show="logoShow"
                     class="logo-block__form" method="post" enctype="multipart/form-data" action="/backend/storeavatar">
                        <button @click.stop="changeAvatar" class="btn btn--green">Change avatar</button>
                        <input id="changeAvatar" class="logo-block__file logo-block__file--hide" name="avatar" type="file" @change="selectFile"/>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input class="btn btn--gray" type="submit" value="Send File" id=""/>
                    </form> 
                </div>

                    <li class="user-info__name">
                        <h2 class="user-info__heading">Name & Vorname</h2>
                        <div>
                            {{ isset($personal_info->name) ? $personal_info->name : '' }}
                            {{ isset($personal_info->last_name) ? $personal_info->last_name : '' }}
                        </div>
                    </li>

                    <li class="user-info__contact">
                        <h2 class="user-info__heading">Kontact</h2>
                        <div class="user-info__phone"><i></i> <span>{{ isset($personal_info->phone) ? $personal_info->phone : '' }}</span></div>
                        <div class="user-info__email"><i></i> <span>{{ isset($personal_info->email) ? $personal_info->email : '' }}</span></div>
                    </li>

                    <li class="user-info__data">
                        <h2 class="user-info__heading">Persönliche Daten</h2>
                        <div><strong>Geschlecht:</strong>{{ isset($personal_info->gender) ? $personal_info->gender : '' }}</div>
                        <div><strong>Geburstag:</strong>{{ isset($personal_info->birthday) ? $personal_info->birthday : '' }}</div>
                        <a href="javascript:void(0);" class="btn btn--red" @click="openUserInfoModal">Jetzt ändern</a>
                    </li>

                </ul>

            </section>
    </template>


@stop

@extends('layouts.layoutDirector')
@section('content')
    <section class="director-dienstleister2 director-main">
        <h1 class="director-content__heading heading heading__h1">Dienstleister</h1>

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
                <img class="user-info__avatar" src="{{isset($employee_avatar) ? $employee_avatar->path : asset('images/default_avatar.png') }}" alt="">
                </div>

                <div>
                    <button
                            v-show="logoShow"
                    @click="logoShow = !logoShow"
                    class="user-info__btn btn btn--red">
                    @{{ logoShow ? 'Do not change' : 'Change' }}
                    </button>

                    <form
                            @submit.prevent="setAvatar({{$personal_info->id}})"
                            v-show="logoShow"
                            class="logo-block__form" method="post" enctype="multipart/form-data" action="{{$_SERVER['REQUEST_URI']}}/storeavatar">
                        <button @click.prevent.stop="changeAvatar" class="btn btn--green">Change avatar</button>
                        <input @change="selectFile" id="changeAvatar" class="logo-block__file logo-block__file--hide" name="avatar" type="file"/>
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
                </li>

                <li class="user-info__data">
                    <h2 class="user-info__heading">Status</h2>
                    <div><strong>Geschlecht:</strong>{{ isset($personal_info->group) ? $personal_info->group : '' }}</div>
                    <div><strong>Geburstag:</strong>{{ isset($personal_info->status) ? $personal_info->status : '' }}</div>
                    <a href="javascript:void(0);" class="btn btn--red" @click="openUserInfoModal">Jetzt ändern</a>
                </li>

            </ul>

        </section>
    </template>

    <template id="editing-modal-template">
    <div class="remodal kalendar-form" id="userInfoModal">
      <button data-remodal-action="close" class="remodal-close"><i></i></button>

      <div class="block">
          <ul class="block__nav">
              <li data-tab="tab-1" class="block__item is-active">Change personal info</li>
              <li data-tab="tab-2" class="block__item">Change password</li>
              <li data-tab="tab-3" class="block__item">Change email</li>
          </ul>

          <div data-tab-id="tab-1" class="tab-content is-active">
              <form class="kalendar-form__form" id="infoForm">
                <fieldset class="kalendar-form__fieldset">
                    <div class="kalendar-form__row">
                        <input
                        v-model="editingInfo.name"
                        class="kalendar-form__input kalendar-input"
                        placeholder="Name"
                        name="name"
                        type="text">
                        <input
                        v-model="editingInfo.last_name"
                        class="kalendar-form__input kalendar-input"
                        placeholder="Vorname"
                        name="last_name"
                        type="text">
                    </div>
                    <div class="kalendar-form__row">
                        <input
                        v-model="editingInfo.phone"
                        class="kalendar-form__input kalendar-input"
                        placeholder="phone"
                        name="phone"
                        type="text">
                        <input
                        v-model="editingInfo.birthday"
                        class="kalendar-form__input kalendar-input input-date"
                        name="birthday"
                        type="text">
                    </div>
                    <div class="kalendar-form__row kalendar-form__row--profil">
                        <select
                        v-model="editingInfo.gender" 
                        class="kalendar-form__input kalendar-form__input--3 kalendar-input" name="gender">
                            <option 
                            v-for="gender in genders"
                            value="@{{ gender.value }}">@{{ gender.text }}</option>
                        </select>
                        <select 
                        v-model="editingInfo.group"
                        class="kalendar-form__input kalendar-form__input--3  kalendar-input" name="group">
                            <option 
                            v-for="group in groups"
                            value="@{{ group.value }}">@{{ group.text }}</option>
                        </select>
                        <select 
                        v-model="editingInfo.status"
                        class="kalendar-form__input kalendar-form__input--3 kalendar-input" name="status">
                            <option 
                            v-for="status in statuses"
                            value="@{{ status.value }}">@{{ status.text }}</option>
                        </select>
                    </div>
                </fieldset>

                <fieldset class="kalendar-form__fieldset">
                  <input class="kalendar-form__submit btn btn--red" type="submit" value="Edit">
                </fieldset>
              </form>
          </div>

          <div data-tab-id="tab-2" class="tab-content">
              <form class="kalendar-form__form" id="passwordForm" action="" method="POST">
                  <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__password kalendar-input" type="password" name="old_password" placeholder="Current password">
                    <input 
                     class="kalendar-form__password kalendar-input newPass1" 
                     type="password" name="new_password-1" placeholder="New password">
                    <input 
                    class="kalendar-form__password kalendar-input"
                     type="password" name="new_password-2" placeholder="New password">
                  </fieldset>

                  <div 
                  v-show="errors.password"
                  class="vue-error"
                  >Неправильный пароль</div>

                  <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__submit btn btn--red" type="submit" value="Edit">
                  </fieldset>
              </form>
          </div>
          <div data-tab-id="tab-3" class="tab-content">
              <form class="kalendar-form__form" id="emailForm" action="" method="POST">
                  <fieldset class="kalendar-form__fieldset">
                      <input
                              v-model="editingInfo.email"
                              class="kalendar-form__input kalendar-input"
                              placeholder="E-mail"
                              name="email"
                              type="email">
                  </fieldset>

                  <div 
                  v-show="errors.email"
                  class="vue-error"
                  >Неправильный пароль</div>

                  <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__submit btn btn--red" type="submit" value="Edit">
                  </fieldset>
              </form>
          </div>
        </div>


    </div>

</div>
</template>
@stop

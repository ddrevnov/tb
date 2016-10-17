<template id="editing-modal-template">
    <div class="remodal kalendar-form" id="userInfoModal">
        <button data-remodal-action="close" class="remodal-close"><i></i></button>

        <div class="block">
            <ul class="block__nav">
                <li data-tab="tab-1" class="block__item is-active">{{trans('common.change_personal_info')}}</li>
                <li data-tab="tab-2" class="block__item">{{trans('common.change_password')}}</li>
                <li data-tab="tab-3" class="block__item">{{trans('common.change_e-mail')}}</li>
            </ul>

            <div data-tab-id="tab-1" class="tab-content is-active">
                <form
                class="kalendar-form__form" id="infoForm" method="POST">
                    <fieldset class="kalendar-form__fieldset">
                        <div class="kalendar-form__row">
                            <div>
                                <input
                                    v-model="editingInfo.name"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="{{trans('common.first_name')}}"
                                    name="name"
                                    type="text">
                            </div>
                            <div>
                                <input
                                    v-model="editingInfo.last_name"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="{{trans('common.last_name')}}"
                                    name="last_name"
                                    type="text">
                            </div>
                        </div>
                        <div class="kalendar-form__row">
                            <div>
                                <input
                                    v-model="editingInfo.phone"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="{{trans('common.mobile')}}"
                                    name="phone"
                                    type="text">
                            </div>
                            <div>
                                <input
                                    v-model="editingInfo.birthday"
                                    class="kalendar-form__input kalendar-input input-date"
                                    placeholder="{{trans('common.birthday')}}"
                                    name="birthday"
                                    type="text">
                            </div>
                        </div>
                        <div class="kalendar-form__row">
                            <div>
                                <select
                                v-model="editingInfo.gender"
                                class="kalendar-form__input kalendar-input" name="gender">
                                    <option value="male">{{trans('common.male')}}</option>
                                    <option value="female">{{trans('common.female')}}</option>
                            </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__submit btn btn--red" value="{{trans('common.edit')}}" type="submit">
                    </fieldset>
                </form>
            </div>

            <div data-tab-id="tab-2" class="tab-content">
                <form
                class="kalendar-form__form" id="passwordForm" action="" method="POST">
                    <fieldset class="kalendar-form__fieldset">
                        <div>
                            <input class="kalendar-form__password kalendar-input"
                                   type="password" name="old_password" placeholder="{{trans('common.current_password')}}">
                        </div>
                        <div>
                            <input
                                class="kalendar-form__password kalendar-input newPass1"
                                type="password" name="new_password-1" placeholder="{{trans('common.new_password')}}">
                        </div>
                        <div>
                            <input
                                class="kalendar-form__password kalendar-input"
                                type="password" name="new_password-2" placeholder="{{trans('common.new_password')}}">
                        </div>
                    </fieldset>

                    <fieldset class="kalendar-form__fieldset">
                       <input class="kalendar-form__submit btn btn--red" type="submit" value="{{trans('common.edit')}}">
                    </fieldset>
                </form>
            </div>
            <div data-tab-id="tab-3" class="tab-content">
                <form
                class="kalendar-form__form" id="emailForm" action="" method="POST">
                    <fieldset class="kalendar-form__fieldset">
                        <div>
                            <input
                                v-model="editingInfo.email"
                                class="kalendar-form__input kalendar-input"
                                placeholder="{{trans('common.e-mail')}}"
                                name="email"
                                type="email">
                        </div>
                    </fieldset>

                    <div
                            v-show="errors.email"
                            class="vue-error"
                    >{{trans('common.wrong_email')}}</div>

                    <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__submit btn btn--red" type="submit" value="{{trans('common.edit')}}">
                    </fieldset>
                </form>
            </div>
        </div>


    </div>

    </div>
</template>
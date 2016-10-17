@extends('layouts.layoutAdmin')
@section('content')

<section class="admin-settings director-main">
    <h1 class="director-content__heading heading heading__h1">{{trans('common.firm_details')}}</h1>

    <div class="director-content">

        <firmdetails-vue></firmdetails-vue>

    </div>

</section>

<template id="firmdetails-template">
    <div class="remodal kalendar-form" id="firmDetailsModal">
        <button data-remodal-action="close" class="remodal-close"><i></i></button>

        <div class="block">
            <ul class="block__nav">
                <li data-tab="tab-40" class="block__item is-active">{{trans('common.firm_details')}}</li>
            </ul>

            <div data-tab-id="tab-40" class="tab-content is-active">
                <form method="POST" action="/office/set_firm_details" class="kalendar-form__form" id="firmDetailsForm">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <fieldset class="kalendar-form__fieldset">
                        <div class="kalendar-form__row">
                            <div>
                                <input
                                    v-model="editingInfo.firm_name"
                                    name="firm_name"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="{{trans('firmdetails.firm_name')}}"
                                    type="text">
                            </div>
                            <div>
                                <input
                                    v-model="editingInfo.firm_telnumber"
                                    name="firm_telnumber"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="{{trans('firmdetails.firm_telnumber')}}"
                                    type="text">
                            </div>
                        </div>
                        <div class="kalendar-form__row">
                            <div>
                                <input
                                    v-model="editingInfo.street"
                                    name="street"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="{{trans('common.street')}}"
                                    type="text">
                            </div>
                            <div>
                                <input
                                    v-model="editingInfo.post_index"
                                    name="post_index"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="{{trans('common.post_index')}}"
                                    type="text">
                            </div>
                        </div>
                        <div class="kalendar-form__row">
                            <div>
                                <select
                                @change="getStates(editingInfo.country_id)"
                                v-model="editingInfo.country_id"
                                class="kalendar-form__input kalendar-input"
                                placeholder="{{trans('common.country')}}"
                                type="text"
                                name="country">
                                <option
                                        v-for="country in countries"
                                        :value="country.country_id">
                                    @{{ country.name }}
                                </option>
                                </select>
                            </div>
                            <div>
                                <select
                                @change="getCities(editingInfo.state_id)"
                                v-model="editingInfo.state_id"
                                class="kalendar-form__input kalendar-input"
                                placeholder="{{trans('common.state')}}"
                                type="text"
                                name="state">
                                <option
                                        v-for="state in states"
                                        :value="state.state_id">
                                    @{{ state.name }}
                                </option>
                                </select>
                            </div>
                        </div>

                        <div class="kalendar-form__row">
                            <div>
                                <select
                                        v-model="editingInfo.city_id"
                                        class="kalendar-form__input kalendar-input"
                                        placeholder="{{trans('common.city')}}"
                                        type="text"
                                        name="city">
                                    <option
                                            v-for="city in cities"
                                            :value="city.city_id">
                                        @{{ city.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </fieldset>

                    <fieldset class="kalendar-form__fieldset">
                        <input class="kalendar-form__submit btn btn--red" type="submit" value="{{trans('common.save')}}">
                    </fieldset>
                </form>
            </div>

            </div>
        </div>


    </div>

    </div>

    <div class="block">

            <ul class="block__nav">
                <li data-tab="tab-1" class="block__item is-active">{{trans('firmdetails.about_us')}}</li>
                <li data-tab="tab-2" class="block__item">{{trans('firmdetails.logo')}}</li>
                <li @click.stop="getWorktimes" data-tab="tab-3" class="block__item">{{trans('firmdetails.work_times')}}</li>
                <li data-tab="tab-4" class="block__item">{{trans('firmdetails.place')}}</li>
            </ul>

            <div data-tab-id="tab-1" class="tab-content is-active">
                <pre class="admin-settings__text">{{isset($about_us) ? $about_us->about_us : ''}}</pre>
                <textarea id="text-area__text" cols="50" rows="10" contenteditable="true"></textarea><br>
                <a class="admin-settings__btn btn btn--red" href="#" id="aboutus_edit">{{trans('common.edit')}}</a>
            </div>

            <div  data-tab-id="tab-2" class="tab-content">

            <logo-vue></logo-vue>
                
            </div>

            <div data-tab-id="tab-3" class="tab-content">
                <work-times-vue></work-times-vue>
            </div>

            <div data-tab-id="tab-4" class="tab-content">
                <table class="table table--striped">

                    <tr>
                        <td>{{trans('firmdetails.firm_name')}}</td>
                        <td><span class="td-data-2">{{isset($firm_info->firm_name) ? $firm_info->firm_name : ''}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>{{trans('firmdetails.firm_telnumber')}}</td>
                        <td><span class="td-data-2">{{isset($firm_info->firm_telnumber) ? $firm_info->firm_telnumber : ''}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>{{trans('common.street')}}</td>
                        <td><span class="td-data-2">{{isset($firm_info->street) ? $firm_info->street : ''}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>{{trans('common.post_index')}}</td>
                        <td><span class="td-data-2">{{isset($firm_info->post_index) ? $firm_info->post_index : ''}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>{{trans('common.state')}}</td>
                        <td><span class="td-data-2">{{isset($firm_info->state) ? $firm_info->state : ''}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>{{trans('common.city')}}</td>
                        <td><span class="td-data-2">{{isset($firm_info->city) ? $firm_info->city : ''}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>{{trans('common.country')}}</td>
                        <td><span class="td-data-2">{{isset($firm_info->country) ? $firm_info->country : ''}}</span>
                        </td>
                    </tr>

                </table>
                <a
                @click="openModal" 
                href="javascript:void(0);" class="admin-settings__btn btn btn--red f-right">{{trans('common.edit')}}</a>
            </div>

    </div>
</template>

<template id="logo-template">
    <alert
            :show.sync="showLogoSuccess"
            :duration="3000"
            type="success"
            width="400px"
            placement="top-right"
            dismissable
    >
        <span class="icon-ok-circled alert-icon-float-left"></span>
        <strong>{{trans('common.well_done')}}</strong>
        <p>{{trans('common.logo_error')}}</p>
    </alert>
    <div class="logo-block">
        <div class="logo-block__box">
            <a 
            @click.prevent.stop="selectFile"
            class="logo-block__btn btn btn--gray" href="javascript:void(0);">{{trans('common.choose_file')}}</a>
            <form class="logo-block__form" action="/office/logoedit" method="post" enctype="multipart/form-data">
                <input
                @change="readURL($event)" 
                class="logo-block__file logo-block__file--hide" name="firm_logo" type="file" />
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            </form>
        </div>
        <div class="logo-block__img">
            <div v-show="showImgPreloader" class="user-info__preloader">
                <i></i>
            </div>
            <img id="blah" src="{{{isset($firmlogo) ? $firmlogo->firm_logo : '/images/logos/blank_logo.png'}}}" alt="">
        </div>
        <a 
        @click.stop.prevent="sendForm"
        class="logo-block__btn btn btn--red" href="javascript:void(0);">{{trans('common.send')}}</a>
    </div>
</template>
@stop
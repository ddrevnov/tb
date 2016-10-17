@extends('layouts.layoutAdmin')
@section('content')
    <section class="admin-kalendar director-main">
        <h1 class="heading heading__h1">{{trans('common.calendar')}}</h1>

        <div class="director-content">
            <kalendar-vue></kalendar-vue>
        </div>

    </section>

<template id="kalendar-template">
    <div id="tablePreloader"></div>
    <input
     type="hidden" name="employee_id" value="{{isset($employee_id) ? $employee_id : ''}}">
<div class="remodal kalendar-form" data-remodal-id="kalendarModal">
                <button data-remodal-action="close" class="remodal-close"><i></i></button>

                <div class="block">

                    <ul class="block__nav">
                        <li
                        v-show="showTab1"
                         data-tab="tab-1" class="block__item is-active">{{trans('calendar.add_order')}}</li>
                        <li
                        v-show="showTab2"
                        @click="show = true"
                         data-tab="tab-2" class="block__item">{{trans('calendar.add_holiday')}}</li>
                    </ul>

                    <div v-show="showTab1" data-tab-id="tab-1" class="tab-content is-active">
                      <form
                        @submit.prevent="sendKalendarForm"
                         class="kalendar-form__form" id="terminForm">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" name="action" value="@{{ action }}">
                            <fieldset class="kalendar-form__fieldset">

                                <div class="kalendar-form__row">
                                    <div>
                                    <typeahead
                                      name="vorname"
                                      :data="names"
                                      placeholder="{{trans('common.first_name')}}">
                                    </typeahead>
                                      <!-- <input
                                      v-model="editCart.first_name"
                                       type="text" 
                                       id="vornameInput"
                                       class="kalendar-form__input kalendar-input" 
                                       placeholder="Vorname"
                                       name="vorname"> -->
                                    </div>
                                    <div>
                                    <typeahead
                                      name="nachname"
                                      :data="lastNames"
                                      placeholder="{{trans('common.last_name')}}">
                                    </typeahead>
                                      <!-- <input
                                        v-model="editCart.last_name"
                                       type="text" class="kalendar-form__input kalendar-input"
                                       placeholder="Nachname" name="nachname"> -->
                                    </div>
                                </div>

                                <div class="kalendar-form__row">

                                   <div>
                                   <typeahead
                                      name="email"
                                      :data="emails"
                                      id="email"
                                      placeholder="{{trans('common.e-mail')}}">
                                    </typeahead>
                                    <!-- <input
                                      v-model="editCart.email"
                                      @change="checkEmail"
                                      type="text" class="kalendar-form__input kalendar-input" placeholder="E-Mail"
                                      name="email"> -->
                                   </div>

                                   <div>
                                   <typeahead
                                      name="phone"
                                      :data="phonesNumbers"
                                      placeholder="{{trans('common.telephone')}}">
                                    </typeahead>
                                     <!-- <input
                                    v-model="editCart.telephone"
                                     type="text" class="kalendar-form__input kalendar-input" placeholder="Telefon"
                                     name="phone"> -->
                                   </div>
                                    
                                </div>

                                <div class="kalendar-form__row">

                                    <div>
                                    <typeahead
                                      name="mobil"
                                      :data="mobilesNumber"
                                      placeholder="{{trans('common.mobile')}}">
                                    </typeahead>
                                      <!-- <input
                                        v-model="editCart.mobile"
                                        type="text" class="kalendar-form__input kalendar-input" placeholder="Mobil"
                                        name="mobil"> -->
                                    </div>

                                    <div>
                                      <input 
                                        v-model="editCart.description"
                                        type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('calendar.notice')}}"
                                        name="description">
                                    </div>

                                </div>

                                <div class="kalendar-form__row">
                                    <select
                                    v-model="service"
                                    @change.stop="showEmployees"
                                    id="kalService"
                                    class="kalendar-form__input kalendar-form__input--service kalendar-input"
                                    name="service">

                                    <option v-if="optionShow" value="" selected>-- 
{{trans('calendar.choose_service')}} --</option>

                                            <optgroup
                                            v-for="(serviceName, servicesArr) in services"
                                            label="@{{ serviceName }}">
                                              <option
                                              v-for="oneservice in servicesArr"
                                              data-duration="@{{ oneservice.duration }}"
                                              :selected="oneservice.service_id == parseInt(service)"
                                              :value="oneservice.service_id">
                                              @{{ oneservice.service_name }} - @{{ oneservice.price }}eur; @{{ oneservice.duration | hourMinutes }}
                                              </option>
                                            </optgroup>

                                    </select>
                                </div>

                                <div class="kalendar-form__row">
                                    <div>
                                    <input
                                      value="@{{ editCart.date }}"
                                      v-model="dateEmpl"
                                      class="kalendar-form__datepicker kalendar-input" name="date" type="text"
                                      placeholder="mm/dd/yyyy" readonly>
                                    </div>

                                    <div>
                                      <input
                                      value="@{{ editCart.time_from }}"
                                      class="kalendar-form__timepicker kalendar-form__timepicker--from kalendar-input"
                                      id="timeFrom"
                                      name="time_from" type="datetime" readonly>
                                    </div>

                                    <div>
                                      <input
                                      v-model="editCart.time_to"
                                      class="kalendar-form__timepicker--to kalendar-input"
                                      id="timeTo"
                                      name="time_to" type="text" readonly>
                                    </div>

                                    <div class="kalendar-form__row">
                                        <select
                                        @change="showServices"
                                         v-model="employeeId"
                                         class="kalendar-form__input kalendar-form__input--service kalendar-input"
                                                name="employee" id="emplSelect">
                                                <option
                                                v-for="employee in employees" 
                                                v-bind:value="employee.id"
                                                >@{{ employee.name }}</option>
                                        </select>
                                    </div>

                                    <input class="kalendar-form__colorpicker kalendar-form__colorpicker--1" name="color" type="text" value="@{{ editCart.color || '#00FFFF' }}">
                                </div>

                                <div class="kalendar-form__row">
                                  <div>
                                    <div>
                                      <label>
                                        <input v-model="sendSms" name="send_sms" type="checkbox" :value="sendSms ? 1 : 0">
                                        SMS
                                      </label>
                                    </div>
                                    <div>
                                      <label>
                                        <input v-model="sendEmail" name="send_email" type="checkbox" :value="sendEmail ? 1 : 0">
                                        Email
                                      </label>
                                    </div>
                                  </div>
                                </div>

                                <div>
                                  <label v-if="checkboxShow">
                                    <input name="new" value="1" type="checkbox" checked>Registration
                                  </label>
                                </div>

                                <span
                                class="kalendar-form__error"
                                v-show="kalendarDisabled">
                                @{{ reason }}
                                </span>

                            </fieldset>
                            <fieldset class="kalendar-form__fieldset">
                                <button 
                                @click.prevent.stop="sendDelete($event, '/office/add_calendar')"
                                v-if="action == 'edit'"
                                class="btn btn--green">{{trans('common.delete')}}</button>
                                <input 
                                class="kalendar-form__submit btn btn--red"
                                 id="kalendarSubmit"
                                 type="submit"
                                 value="{{ action == 'create' ? '<?=trans("common.create")?>': '<?=trans("common.edit")?>' }}"
                                 disabled="@{{ kalendarDisabled }}">
                            </fieldset>
                      </form>
                    </div>

                    <div v-show="showTab2" data-tab-id="tab-2" class="tab-content is-active">
                        <form
                        @submit.prevent="sendEreignisForm"
                         v-show="show"
                         class="kalendar-form__form" action="" method="POST" id="ereignisForm">
                         <input type="hidden" name="action" value="@{{ action }}">
                            <fieldset class="kalendar-form__fieldset">

                                <div class="kalendar-form__row">
                                    <input
                                    v-model="timeFromEreignis"
                                    class="kalendar-form__timepicker kalendar-form__timepicker--from kalendar-input"
                                     name="time_from" type="text" 
                                     value="@{{ editCart.time_from }}" 
                                     readonly>
                                    <input
                                    v-model="timeToEreignis"
                                    id="timeHolidayTo"
                                    class="kalendar-form__timepicker kalendar-form__timepicker--to kalendar-input"
                                           name="time_to" type="text" 
                                           value="@{{ editCart.time_from }}"
                                           readonly>
                                        <select
                                        @change="showServices"
                                         v-model="employeeId"
                                         class="kalendar-form__input kalendar-form__input--service kalendar-input"
                                         name="employee" id="">
                                                <option
                                                selected="@{{ employee.id == id }}"
                                                v-for="employee in employees" value="@{{ employee.id }}"
                                                >@{{ employee.name }}</option>
                                        </select>
                                </div>

                                <div class="kalendar-form__row">
                                    <input 
                                    class="kalendar-form__input kalendar-input"
                                    type="text"
                                    name="description" 
                                    placeholder="{{trans('calendar.cause')}}">
                                </div>

                                <div class="kalendar-form__row">
                                    <input 
                                    name="color"
                                    class="kalendar-form__colorpicker kalendar-form__colorpicker--2" type="text">
                                    <div class="color-box">
                                      <div class="color-box__in"></div>
                                    </div>
                                    <div>
                                    <input
                                    v-model="dateFrom"
                                    value="@{{ dateEmpl }}"
                                    class="kalendar-form__datepicker kalendar-input" 
                                    id="ereignisDateFrom"
                                    name="date_from" 
                                    type="text"
                                    placeholder="mm/dd/yyyy">
                                    <input
                                    v-model="dateTo"
                                    value="@{{ dateEmpl }}"
                                    class="kalendar-form__datepicker kalendar-input" 
                                    id="ereignisDateTo"
                                    name="date_to" 
                                    type="text"
                                    placeholder="mm/dd/yyyy">
                                    </div>
                                </div>

                                <div
                                v-show="showEreignisError" 
                                class="kalendar-form__error">Geben Sie ein anderes Datum</div>

                            </fieldset>

                            <fieldset class="kalendar-form__fieldset">
                              <div class="kalendar-form__row">
                                <button 
                                @click.prevent.stop="sendDelete($event, '/office/add_holiday')"
                                v-if="action == 'edit'"
                                class="btn btn--green">{{trans('common.delete')}}
                                </button>
                                <input class="kalendar-form__submit btn btn--red" type="submit" value="{{ action == 'create' ? '<?=trans("common.create")?>': '<?=trans("common.edit")?>' }}">
                              </div>
                            </fieldset>
                        </form>
                    </div>

                </div>

</div>
<section class="kalendar" id="kalendar">
    @can('admin')
    <div class="kalendar-carousel kalendar__carousel">

        @foreach($employees as $employee)
        <div class="kalendar-carousel__block" data-employee-id="{{$employee->id}}">
            <a href="javascript:void(0);">
                <div class="kalendar-carousel__name">{{$employee->name}}</div>
                <img class="kalendar-carousel__img" src="{{isset($employee->path) ? $employee->path : asset('images/default_avatar.png') }}" alt="">
            </a>
        </div>
        @endforeach

    </div>
    @endcan
 <div class="kalendar__wrap">
  <header class="kalendar__header">


      <a
        @click.stop="openModalBtnClick"
       class="btn btn--green" id="kalendarTermin" href="javascript:void(0);">{{trans('calendar.add_order')}}</a>
      <div class="kalendar__controls">

      <div
      class="week-picker">
      <span id="startDate">@{{ dates[0] }}</span> - <span id="endDate">@{{ dates[6] }}</span>
      </div>
          <div>
              <a
              @click.stop="tableRender(weekInk--)"
              class="kalendar__control kalendar__control--prev" 
              href="javascript:void(0);"><i></i></a>
              <a
              @click.stop="tableRender(weekInk++)"
              class="kalendar__control kalendar__control--next" 
              href="javascript:void(0);"><i></i>
              </a>
          </div>
          <a
          @click.stop="tableRender(weekInk = 0)"
          href="javascript:void(0);"
          class="btn btn--red btn--small">{{trans('calendar.today')}}</a>
      </div>

  </header>

  <div class="table-kal" data-nowork-days="{{isset($work_days) ? $work_days : ''}}">
    <table>
      <tr>
        <th>&nbsp;</th>
      </tr>
      <tr v-if="index % 2 == 0" v-for="(index, time) in rangeTable">
        <th>
            @{{ time }}
        </th>

      </tr>

    </table>

    <table class="tableCalDay" v-for="(dateIndex, date) in dates">
      <tr><th data-date="@{{ date }}">@{{ days[dateIndex] }}. @{{ date }}</th></tr>

      <tr v-for="(index, time) in rangeTable">
          <td @click="openModalTdClick" :data-time="time" data-date="@{{ date }}"></td>
      </tr>

    </table>
  </div>
</div> 
</section>

    </section>


</template>
    @stop


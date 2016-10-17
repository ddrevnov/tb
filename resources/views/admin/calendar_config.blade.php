@extends('layouts.layoutAdmin')
@section('content')
<section class="admin-settings director-main">
    <h1 class="director-content__heading heading heading__h1">Calendar Config</h1>

    <div class="director-content">
        <settings-kalendar-vue></settings-kalendar-vue>
    </div>
</section>

    <template id="settings-kalendar-template">
        <alert
                :show.sync="showSettingsComplete"
                :duration="3000"
                type="success"
                width="400px"
                placement="top-right"
                dismissable
        >
            <span class="icon-ok-circled alert-icon-float-left"></span>
            <strong>Well Done!</strong>
            <p>The settings have been changed</p>
        </alert>
        <div class="block">
            <form class="settings-calendar" @submit.prevent="setSettings" action="/office/kalendar_config/edit" method="post">
                {{csrf_field()}}
                <h3 class="settings-calendar__heading">Reminder minutes:</h3>

	            <input type="checkbox"
	                   name="send_email"
	                   v-model="settings.send_email"
	                   :true-value="1"
	                   :false-value="0">
                <div class="settings-calendar__slider">
                    <div class="tb-slider" id="reminderSlider"></div>
                </div>

                <h3 class="settings-calendar__heading">Reminder sms:</h3>

                <input type="checkbox"
                       name="send_sms"
                       v-model="settings.send_sms"
                       :true-value="1"
                       :false-value="0">
                <div class="settings-calendar__slider">
                    <div class="tb-slider" id="smsReminderSlider"></div>
                </div>
                {{--<input v-model="settings.h_reminder" number type="text" id="reminderSlider2">--}}
                <input type="submit" value="{{trans('common.save')}}" class="btn btn--red settings-calendar__btn">
            </form>
        </div>
    </template>
@stop

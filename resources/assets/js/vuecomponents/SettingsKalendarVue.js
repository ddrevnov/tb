import Vue from 'vue'
import filters from '../filters.js'
import * as ajax from '../ajax.js'
import Alert from './vue-strap/src/Alert.vue'
//import 'ion-rangeslider'

let SettingsKalendarVue = Vue.component('settings-kalendar-vue', {
  template: '#settings-kalendar-template',

  filters: filters,

  components: { Alert },

  data() {
    return {
      settings: {},
      showSettingsComplete: false
    }
  },

  ready() {
    this.getSettings();
    //$("#reminderSlider2").ionRangeSlider({
    //  type: "double",
    //  min: 30,
    //  max: 2880,
    //  from_min: 30,
    //  grid: true,
    //  step: 15
    //});
  },

  methods: {

    setSettings() {
      let data = this.settings;
      let path = '/office/kalendar_config/edit';

      ajax.sendAjax(data, path)
        .done(() => {
          this.showSettingsComplete = true;
        });
    },

    getSettings() {
      let data = {};
      let path = '/office/kalendar_config/get_config';
      return ajax.sendAjax(data, path)
        .done((settings) => {
          this.settings = settings;
          this.sliderInit();
          this.smsSliderInit();
        });
    },

    sliderInit() {
      let vm = this;
      let slider = $( "#reminderSlider" );
      let min = 30;
      let max = 2880;

      let appendHandle = function() {
        slider.find('.ui-slider-handle').append(`
            <span class="tb-slider__show" id="reminderHandle">${filters.hourMinutes(vm.settings.h_reminder)}</span>
          `);
      };

      slider.slider({
        max: max,
        min: min,
        step: 15,
        range: "min",
        value: vm.settings.h_reminder,
        slide: function( event, ui ) {
          vm.settings.h_reminder = ui.value;

          $('#reminderHandle').remove();
          appendHandle();

        }
      });

      appendHandle();
      slider.append(`
        <span class="tb-slider__show tb-slider__show--min">${filters.hourMinutes(min)}</span>
      `);

      slider.append(`
        <span class="tb-slider__show tb-slider__show--max">${filters.hourMinutes(max)}</span>
      `);

    },

    smsSliderInit() {
      let vm = this;
      let slider = $( "#smsReminderSlider" );
      let min = 30;
      let max = 2880;

      let appendHandle = function() {
        slider.find('.ui-slider-handle').append(`
            <span class="tb-slider__show" id="reminderHandle">${filters.hourMinutes(vm.settings.sms_reminder)}</span>
          `);
      };

      slider.slider({
        max: max,
        min: min,
        step: 15,
        range: "min",
        value: vm.settings.sms_reminder,
        slide: function( event, ui ) {
          vm.settings.sms_reminder = ui.value;

          $('#reminderHandle').remove();
          appendHandle();

        }
      });

      appendHandle();
      slider.append(`
        <span class="tb-slider__show tb-slider__show--min">${filters.hourMinutes(min)}</span>
      `);

      slider.append(`
        <span class="tb-slider__show tb-slider__show--max">${filters.hourMinutes(max)}</span>
      `);

    }
  }
});

export default SettingsKalendarVue;
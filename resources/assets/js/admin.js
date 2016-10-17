import App from './modules/App.js'
import Vue from 'vue'
import moment from 'moment'
import KalendarVue from './vuecomponents/KalendarVue.js'
import ChatVue from './vuecomponents/ChatVue.js'
import EditingModalVue from './vuecomponents/EditingModalVue.js'
import UserInfoVue from './vuecomponents/UserInfoVue.js'
import ServicesVue from './vuecomponents/ServicesVue.js'
import HeaderVue from './vuecomponents/HeaderVue.js'
import TariffsVue from './vuecomponents/TariffsVue.js'
import DashboardVue from './vuecomponents/DashboardVue.js'
import LogoVue from './vuecomponents/LogoVue.js'
import OrdersVue from './vuecomponents/OrdersVue.js'
import SidebarVue from './vuecomponents/SidebarVue.js'
import FirmDetailsVue from './vuecomponents/FirmDetailsVue.js'
import TariffVue from './vuecomponents/TariffVue.js'
import BillingVue from './vuecomponents/BillingVue.js'
import NewsletterVue from './vuecomponents/NewsletterVue.js'
import EmployeesListVue from './vuecomponents/EmployeesListVue.js'
import AssistantVue from './vuecomponents/AssistantVue.vue'
import SmsinfoVue from './vuecomponents/SmsinfoVue.js'
import DirectorstatsVue from './vuecomponents/DirectorstatsVue.js'
import HeaderTimeVue from './vuecomponents/HeaderTimeVue.vue'
import SettingsKalendarVue from './vuecomponents/SettingsKalendarVue.js'
import Alert from './vuecomponents/vue-strap/src/Alert.vue'
import VueI18n  from 'vue-i18n'
import VueResource from 'vue-resource'
import * as ajax from './ajax.js'
import {LOCALES} from './lang.js'

import './i18n/datepicker-ru'
import './i18n/datepicker-de'
import './i18n/datepicker-en-AU'

import 'moment/locale/de'
import 'moment/locale/en-au'
import 'moment/locale/ru'


Vue.use(VueResource);
Vue.use(VueI18n);

let locale = 'de';

Vue.config.lang = locale;

// set locales
Object.keys(LOCALES).forEach(function (lang) {
  Vue.locale(lang, LOCALES[lang])
});

$(document).ready(function() {

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  new Vue({
    el: 'body',

    data() {
      return {
        locale: $('meta[name="locale"]').attr('content'),
        showCreateEmplAlert: false
      }
    },

    components: {
      KalendarVue,
      ChatVue,
      EditingModalVue,
      UserInfoVue,
      ServicesVue,
      HeaderVue,
      TariffsVue,
      DashboardVue,
      LogoVue,
      OrdersVue,
      SidebarVue,
      FirmDetailsVue,
      TariffVue,
      BillingVue,
      NewsletterVue,
      AssistantVue,
      HeaderTimeVue,
      SettingsKalendarVue,
      Alert,
      SmsinfoVue,
      DirectorstatsVue,
      EmployeesListVue
    },

    ready() {
      console.log('vue init');
      $('#sitePreloader').fadeOut('slow',function(){$(this).remove();});
      this.changeLang();
      $.datepicker.setDefaults( $.datepicker.regional[ this.locale ] );
      this.timePickerInit();
      moment.locale(this.locale);
    },

    methods: {

      goTo(link) {
        window.location.href = link;
      },

      submitCreateEmpl() {
        let data = ajax.getFormData($('#userInfoForm'));
        let path = `/${ajax.pathWho}/employees/store`;
        ajax.sendAjax(data, path)
          .done((res) => {
            if (res) {
              window.reload();
            } else {
              this.showCreateEmplAlert = true;
            }
          })
          .fail((err)=> {
            throw new Error(err);
          });
      },

      timePickerInit() {

        $.timepicker.regional['ru'] = {
          timeOnlyTitle: 'Выберите время',
          timeText: 'Время',
          hourText: 'Часы',
          minuteText: 'Минуты',
          secondText: 'Секунды',
          millisecText: 'Миллисекунды',
          timezoneText: 'Часовой пояс',
          currentText: 'Сейчас',
          closeText: 'Закрыть',
          timeFormat: 'HH:mm',
          amNames: ['AM', 'A'],
          pmNames: ['PM', 'P'],
          isRTL: false
        };

        $.timepicker.regional['de'] = {
          timeOnlyTitle: 'Wählen Sie Zeit',
          timeText: 'Zeit',
          hourText: 'Uhr',
          minuteText: 'Minuten',
          secondText: 'Sekunden',
          millisecText: 'Millisekunde',
          timezoneText: 'Zeitzone',
          currentText: 'im Moment',
          closeText: 'schließen',
          timeFormat: 'HH:mm',
          amNames: ['AM', 'A'],
          pmNames: ['PM', 'P'],
          isRTL: false
        };

        $.timepicker.regional['en'] = {
          timeOnlyTitle: 'Select time',
          timeText: 'Time',
          hourText: 'Hours',
          minuteText: 'Minutes',
          secondText: 'Seconds',
          millisecText: 'Millisecond',
          timezoneText: 'Timezone',
          currentText: 'Now',
          closeText: 'Close',
          timeFormat: 'HH:mm',
          amNames: ['AM', 'A'],
          pmNames: ['PM', 'P'],
          isRTL: false
        };

        $.timepicker.setDefaults($.timepicker.regional[this.locale]);

        $('.worktime-timepicker, .kalendar-form__timepicker').timepicker({
          stepMinute: 15,
          defaultValue: '8:00',
          timeFormat: 'H:mm',
        });
      },

      changeLang() {
        let locale = this.locale ? this.locale: 'de';

        Vue.config.lang = locale;

        // set locales
        Object.keys(LOCALES).forEach(function (lang) {
          Vue.locale(lang, LOCALES[lang])
        });
      },

      openModal(modalStr = '.remodal') {
        let modal = $(modalStr).remodal();
        modal.open();
      },

      changeLocale() {
          window.location = `/${ajax.pathWho}/set_locale/${this.locale}`;
      },

      closeModal(modalStr = '.remodal') {
        let modal = $(modalStr).remodal();
        modal.close();
      },

      checkEmail(e, path = '/office/employees/check_email') {
        let $target = $(e.target);
        let value = $target.val();
        let $btn = $target.closest('form').find('.btn[type="submit"]');
        let errorMess = `
          <br><div class="vue-error email-error">
            E -Mail nicht verfügbar ist, wählen Sie einen anderen.
          </div>
        `;
        let data = {
          email: value
        }

        ajax.sendAjax(data, path)
          .done((res) => {
            $('.email-error').remove();
            $btn.prop('disabled', false).removeClass('is-disabled');

            if (!res) {
              $target.after(errorMess);
              $btn.prop('disabled', true).addClass('is-disabled');
            }

          });
      }

    },

    events: {

      newMess() {
        this.$broadcast('newMess');
      },

      openModal() {
        let modal = $('.remodal').remodal();
        modal.open();
      },

      closeModal() {
        let modal = $('.remodal').remodal();
        modal.close();
      }

    }
  });

  App.init();

  //select init
  $('.select, .checkbox, .input').styler();

  //Datepicker init
  $('.input-date').datepicker({
   firstDay: 1,
   dateFormat: 'dd/mm/yy',
   changeMonth: true,
   changeYear: true,
   yearRange: "-100:+0",
  });



  //SETTINGS ------------------------------------------------------------------
  
  $(document).on({
    'mouseenter': function() {
      var $this = $(this);
      var $settingsIco = $this.find('.settings__ico');
      $settingsIco.addClass('is-hover').closest('.settings').find('.settings__list').show();
    },

    'mouseleave': function() {
      var $this = $(this);
      var $settingsIco = $this.find('.settings__ico');
      $settingsIco.removeClass('is-hover').closest('.settings').find('.settings__list').hide();
    }
  }, '.settings');



  //SLICK ----------------------------------------------------------------------------

  if ($('.kalendar-carousel').length) {
    $('.kalendar-carousel').slick({
      slidesToShow: 11,
      prevArrow: '<div class="kalendar-carousel__prev"><i></i></div>',
      nextArrow: '<div class="kalendar-carousel__next"><i></i></div>'
    });
  }


  //-------------------------------------------------------------------------------------------

  var flag = true;

  var token = $(".draft-email");

  var tokObj = [];
  token.each(function(){
    tokObj.push({id: $(this).data('draft-id'), name: $(this).data('draft-email')});
  })

  $("#inputClient").tokenInput("/office/get_client_email", {
    theme: "facebook",
    tokenLimit: null,
    prePopulate: tokObj
  });

  $("#inputAdmin").tokenInput(`/${ajax.pathWho}/get_admin_email`, {
    theme: "facebook",
    tokenLimit: null,
    prePopulate: tokObj
  });

  $('.radio').on('change', function (event) {
    switch (event.currentTarget.defaultValue) {
      case 'all':
        $(".clients").hide();
        break;
      case 'some':
        $(".clients").show();
        break;
    }
  });



  //preview modal for newsletter
  var modal = $('#mailModal').remodal();
  var vorschau = $('#vorschau');
  vorschau.on('click', function () {
    $('.kalendar-form__input--betref').val($('#betreff').val());
    $('.kalendar-form__input--von').val($('#von').val());
    $('.kalendar-form__input--signatur').val($('.clients p').html());
    $('.kalendar-form__input--text').html(CKEDITOR.instances.text.getData());
    modal.open();
  });

  $('input[name="img"]').on('change', function (input) {

    if (this.files && this.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#blah')
            .attr('src', e.target.result)
            .style('width: 100%');
      };

      reader.readAsDataURL(this.files[0]);
    }
  });

  $('#speichern').click(function () {
    $('.form-article').attr('action', 'newsletter_save');
    $('.form-article').submit();
  });


  $('.delete-slide').on('click', function (e) {
    return confirm('Are you shure?');
  });

//TABLE SORTER FOR ADMIN

  $.tablesorter.addParser({
    id: 'checkbox',
    is: function (s, table, cell) {
      return $(cell).find('input[type="checkbox"]').length > 0;
    },
    format: function (s, table, cell) {
      return $(cell).find('input:checked').length > 0 ? 0 : 1;
    },
    type: "numeric"
  });
  
  if ($("#clients-table").find("tr").size() > 1)
  {
    $("#clients-table").tablesorter();
  }

  if ($("#client-orders-list").find("tr").size() > 1)
  {
    $("#client-orders-list").tablesorter();
  }

  if ($("#newsletter-table").find("tr").size() > 1)
  {
    $("#newsletter-table").tablesorter();
  }

  if ($("#profil-services-table").find("tr").size() > 1)
  {
    $("#profil-services-table").tablesorter({"headers":{"2":{"sorter":"checkbox"}}});
  }

  if ($("#calendar-table").find("tr").size() > 1)
  {
    $("#calendar-table").tablesorter({dateFormat: "uk"});
  }

  $('#admin-to-empl').on('click', function(e){
    e.preventDefault();
    $('#admin-to-empl-section').show();
  })

  $('#empl-to-admin').on('click', function(e){
    e.preventDefault();
    if(confirm('Are you shure?')) {
      $('#empl-to-admin-section').hide();
    }

    $.ajax({
      url: '/office/profil_admin/to_admin',
      type: 'POST',
      dataType: 'Json',
      success: function (response) {
        location.reload();
      }
    });

  });

  // menu tabs smsinfo
  $('.nav_sms_menu li').click(function(){
    var attrSms = $(this).attr('data-tab');
    console.log($('.all_sms_info_block').children('tab_content').removeClass('is-active'));
    $('.nav_sms_menu li').removeClass('is-active');
    $(this).addClass('is-active');
    $('.all_sms_info_block').find('[data-tab-id]').removeClass('is-active');
    $('.all_sms_info_block').find('[data-tab-id='+attrSms+']').addClass('is-active');
  });

  // $('.single_tarif').click(function() {
  //   $('.all_tarifs').removeClass('active');
  //   $('.detail_info').addClass('active');
  // });
});

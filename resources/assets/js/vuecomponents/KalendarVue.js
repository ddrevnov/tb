import Vue from 'vue'
import moment from 'moment'
import * as ajax from '../ajax.js'
import * as lib  from '../lib.js'
import filters from '../filters.js'
import Typeahead  from './vue-strap/src/Typeahead.vue'
import { LOCALES }  from '../lang'


  let KalendarVue = Vue.component('kalendar-vue', {
    template: '#kalendar-template',

    components: { Typeahead },

    data() {
      return {
        sendSms: true,
        sendEmail: false,
        carts: [],
        dates: this.getWeekArr(),
        days: this.getDays(),
        weekInk: 0,
        startOfWeek: moment().locale(this.$root.locale).startOf('isoWeek'),
        endOfWeek: moment().locale(this.$root.locale).endOf('isoWeek'),
        startTime: '',
        endTime: '',
        timeFromEreignis: '',
        timeToEreignis: '',
        show: false,
        dateFrom: '',
        dateTo: '',
        showEreignisError: false,
        showDateEreignis: true,
        showTab1: true,
        showTab2: true,
        service: null,
        services: null,
        employees: null,
        duration: null,
        employeeId: null,
        dateEmpl: moment().locale(this.$root.locale).format('DD/MM/YYYY'),
        kalendarDisabled: false,
        reason: '',
        action: 'create',
        editCart: {},
        email: '',
        checkboxShow: false,
        emailIsset: false,
        clients: this.getClients(),
        optionShow: false,
        names: [],
        lastNames: [],
        mobilesNumber: [],
        emails: [],
        phonesNumbers: [],
        noWorkDays: [],
        rangeTable: [],
      };
    },

  ready() {
    let vm = this;
    let $carousel = $('.kalendar-carousel');
    let id = $carousel
        .find('.kalendar-carousel__block:first')
        .addClass('is-active')
        .attr('data-employee-id');

    $('#tablePreloader').hide();

    vm.getNoWorkDays();
    vm.timepickerInit();
    vm.getRangeTable();

    //PICKERS ----------------------------------------------------------------------------

    $( ".kalendar-form__datepicker" ).datepicker({
        firstDay: 1,
        inline: true,
        showOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: 'dd/mm/yy'
      });

    $(".kalendar-form__colorpicker--1").spectrum({
        showPaletteOnly: true,
        showPalette:true,
        preferredFormat: "hex",
        hideAfterPaletteSelect:true,
        color: '#00FFFF',
        change: function(color) {
          var $this = $(this);
          var color = color.toHexString();

          $this.attr('value', color);
        },
        palette: [
          ['#7FFFD4', '#FFE4C4', '#00FFFF',
            '#000000', '#0000FF'],
          ['#A52A2A', '#5F9EA0', '#7FFF00', '#D2691E', '#8B008B']
        ]
      });

      $(".kalendar-form__colorpicker--2").spectrum({
        color: "#e64423",
        preferredFormat: "hex",
        change: function(color) {
          color.toHexString(); // #ff0000
        }
      });
  
  let currentDate = new Date();
  $(".kalendar-form__datepicker").datepicker("setDate", currentDate);

    // /PICKERS ----------------------------------------------------------------------------

    $(document).on('blur', '#email', function(e) {
      vm.checkEmail(e);
    });

    $('#timeFrom').on('change', function(e){
      e.stopPropagation();
      vm.startTime = $(this).val();
      vm.getRangeTime();
    });

    $carousel.on('click', '.kalendar-carousel__block', function(e) {
      e.stopPropagation();
      
      $carousel.find('.kalendar-carousel__block').removeClass('is-active');
      let $this = $(this).addClass('is-active');
      let id = $this.attr('data-employee-id');

      vm.employeeId = id;
      vm.tableRender();
    });

    vm.tableRender();
    vm.weekPickerInit();
    $('.week-picker').find('.ui-datepicker').hide();
    
    ajax.getEmployees({})
          .done((employees) => {
            vm.employees = employees;

            if (id) {
              vm.employeeId = id;
            } else {
              vm.employeeId = $('input[name="employee_id"]').val();
              vm.employees = vm.employees.filter((employee) => {
                return employee.id == this.employeeId;
              });
            }
          });

          vm.getServices();

    $(document).on('click', '.cart', (e) => {
      let $cart = $(e.target);
      let isCart = $cart.hasClass('cart');
      let $timeFrom = $('.kalendar-form__timepicker--from');
      let cartId = null;
      let $timeTo = $('#timeTo');
      let $datepicker = $('.kalendar-form__datepicker');
      let $colorpicker = $('.kalendar-form__colorpicker');
      let isEmpl = $('input[name="employee_id"]').val();

      if (isEmpl) {
        vm.employeeId = isEmpl;
      }

      if (!isCart) {
        $cart = $cart.closest('.cart');
      }

      cartId = $cart.attr('data-cart-id');

       vm.getCarts()
        .done((carts) => {
          vm.carts = carts;

          vm.carts.forEach((cart, i) => {
            if(cart.id == cartId) {
              let $form = $('#terminForm');
              vm.editCart = cart;
              vm.service = vm.editCart.service_id;

              setTimeout(() => {
                $timeFrom.val(vm.editCart.time_from);
                $timeTo.val(vm.editCart.time_to);
              }, 400);

              $datepicker.val(vm.editCart.date);
              $colorpicker.val(vm.editCart.color);
              vm.dateEmpl = vm.editCart.date;
              $('.sp-preview-inner')
                .css('backgroundColor', vm.editCart.color);
              vm.kalendarDisabled = false;
              $('#kalendarSubmit').removeClass('is-disabled');
              

              if (!vm.editCart.email) {
                $('[data-tab="tab-2"]').click();
                this.fillEreignisForm();
                vm.showTab2 = true;
                vm.showTab1 = false;
              } else {
                $('[data-tab="tab-1"]').click();
                this.fillTerminForm();
                vm.showTab1 = true;
                vm.showTab2 = false;
              }
            }
          });

          setTimeout(() => {
            let $optionService = $('#kalService').find(`option[value="${vm.service}"]`);

              $optionService.attr('selected', true);
              vm.duration = $optionService.attr('data-duration');
            }, 400);

        });

      vm.action = 'edit';

      return false;
    });

    $(document).on({
      'mouseenter': function() {
        let $this = $(this);
        let cartId = $this.attr('data-cart-id');
        let carts = vm.carts;
        let cart = carts.filter((cart) => {
          return (cart.id == cartId);
        });

        cart = cart[0];
        let color = cart.color;
        let desc = cart.description;
        let name = cart.name;
        let firstName = cart.first_name;
        let lastName = cart.last_name;
        let date = cart.date;
        let id = cart.id;
        let serviceName = cart.service_name;
        let email = cart.email;
        let days = cart.days;
        let serviceTran = LOCALES[vm.$root.locale].all.service;
        let descTran = LOCALES[vm.$root.locale].all.desc;

        let timeFrom = cart.time_from;
        let timeTo = cart.time_to;


        let cartString = `
              <div
                style="
                color: #fff;
                background: ${color};
                "
              class="cart cart--hover"
              >
                  <time class="cart__item">${timeFrom} - ${timeTo}</time>
                  <div class="cart__item">${firstName} ${lastName}</div>
                  <div>${serviceTran}:</div>
                  <div class="cart__item">${serviceName}</div>
                  <div>${descTran}:</div>
                  <div class="cart__item">${desc}</div>
              </div>
            `;

            if (!email) {
              cartString = `
              <div
                data-cart-id="${id}"
                style="
                color: #fff;
                background: ${color};
                width: ${100 * days}%;
                "
              class="cart cart--hover"
              >
                  <time class="cart__item">${timeFrom} - ${timeTo}</time>
                  <div>Description:</div>
                  <div class="cart__item">${desc}</div>
              </div>
            `;
            }

            $this.before(cartString);
      },

      'mouseleave': function() {
          $('.cart--hover').remove();
      },
    }, '.cart');

    $(document).on('closed', '.remodal', function (e) {
      this.editCart = [];
    });

    setTimeout(() => {
      this.tableRender(this.weekInk);
    }, 1000);

  },

  filters: filters,

  watch: {
    dateEmpl() {
      this.getRangeTime();
    }
  },

  methods: {

    getRangeTable(start = '08:00', end = '21:15', interval = 15) {
      let rangeArr = [start];
      let time = start;

      while(time !== end) {
        time = moment(time, 'HH:mm').add(interval, 'minutes').format('HH:mm');
        rangeArr.push(time);
      }

      this.rangeTable = rangeArr;
    },

    timepickerInit() {
      $('.kalendar-form__timepicker--from, #timeHolidayTo').timepicker({
        hourMin: 8,
        hourMax: 21,
        stepMinute: 15
      });
    },

    setNoWorkDays() {
      $('.tableCalDay').each((i, el) => {
        let $table = $(el);
        for (let day of this.noWorkDays) {
          if (+day === i) {
            $table.find('td').addClass('is-blocked');
          }
        }

      });
    },

    getNoWorkDays() {
      let noWorkDays = $('.table-kal').attr('data-nowork-days');
      noWorkDays = JSON.parse(noWorkDays);
      this.noWorkDays = noWorkDays;

      this.setNoWorkDays();
    },

    resetTerminForm() {
      let $form = $('#terminForm');

      $form.find('input[name="vorname"]').val('');
      $form.find('input[name="nachname"]').val('');
      $form.find('input[name="email"]').val('');
      $form.find('input[name="phone"]').val('');
      $form.find('input[name="mobil"]').val('');
    },

    resetEreignisForm() {
      let $form = $('#ereignisForm');

      $form.find('input[name="time_from"]').val('');
      $form.find('input[name="time_to"]').val('');
      $form.find('input[name="description"]').val('');
    },

    fillTerminForm() {
      let $form = $('#terminForm');

      $form.find('input[name="vorname"]').val(this.editCart.first_name);
      $form.find('input[name="nachname"]').val(this.editCart.last_name);
      $form.find('input[name="email"]').val(this.editCart.email);
      $form.find('input[name="phone"]').val(this.editCart.telephone);
      $form.find('input[name="mobil"]').val(this.editCart.mobile);
    },

    fillEreignisForm() {
      let $form = $('#ereignisForm');

      $form.find('input[name="time_from"]').val(this.editCart.time_from);
      $form.find('input[name="time_to"]').val(this.editCart.time_to);
      $form.find('input[name="description"]').val(this.editCart.description);
      $form.find('input[name="date_from"]').val(this.editCart.date_from);
      $form.find('input[name="date_to"]').val(this.editCart.date_to);
    },

    showWeekPicker() {
      $('.week-picker').find('.ui-datepicker').show();
    },

    getNames() {
      let clients = this.clients;
      this.names = clients.map((client) => {
        return client.first_name;
      });
    },

    getLastNames() {
      let clients = this.clients;
      this.lastNames = clients.map((client) => {
        return client.last_name;
      });
    },

    getMobilesNumbers() {
      let clients = this.clients;
      this.mobilesNumber = clients.map((client) => {
        return client.mobile;
      });
    },

    getPhonesNumbers() {
      let clients = this.clients;
      this.phonesNumbers = clients.map((client) => {
        return client.telephone;
      });
    },

    getEmails() {
      let clients = this.clients;
      this.emails = clients.map((client) => {
        return client.email;
      });
    },

    getClients() {
      let vm = this;
      ajax.sendAjax({}, '/office/kalendar/get_clients')
        .done((clients) => {
            vm.clients = clients;
            vm.getNames();
            vm.getLastNames();
            vm.getMobilesNumbers();
            vm.getPhonesNumbers();
            vm.getEmails();
        });
    },

    getRangeTime() {
      let data = {
        start_time: this.startTime,
        duration: this.duration,
        id: this.employeeId,
        date: this.dateEmpl,
        cartId: this.editCart.id
      };
      console.log(data);
      ajax.checkEmployee(data)
        .done((res) => {
          let isCheck = res.check;

          this.endTime = res.end_time;
          $('#timeTo').val(this.endTime);
          let kalendarSubmit = $('#kalendarSubmit');

          if (isCheck) {
            this.kalendarDisabled = false;
            kalendarSubmit.removeClass('is-disabled');
          } else if (res === 0) {
            return;
          } else {
            this.kalendarDisabled = true;

            switch(this.$root.locale) {
              case 'de':
                switch(res.reason) {
                  case 'holiday':
                    this.reason = 'Diese Zeit ist bereits Abschied genommen . Bitte wählen Sie einen anderen .';
                    break;
                  case 'worktime':
                    this.reason = 'Sie haben angegeben Stunden. Bitte wählen Sie einen anderen .';
                    break;
                  case 'order':
                    this.reason = 'Sie geben die Zeit von der Bestellung besetzt . Bitte wählen Sie einen anderen .';
                    break;
                  case 'notime':
                    this.reason = 'Geben Sie die Zeit !';
                    break;
                };
                break;

              case 'en':
                switch(res.reason) {
                  case 'holiday':
                    this.reason = 'This time is already taken leave. Please choose another.';
                    break;
                  case 'worktime':
                    this.reason = 'You have specified hours. Please choose another.';
                    break;
                  case 'order':
                    this.reason = 'Enter the time of the order occupied. Please choose another.';
                    break;
                  case 'notime':
                    this.reason = 'Enter the time!';
                    break;
                };
                break;

              case 'ru':
                switch(res.reason) {
                  case 'holiday':
                    this.reason = 'На этот день у вас выходной. Пожалуйста, выберите другой.';
                    break;
                  case 'worktime':
                    this.reason = 'Выбрано нерабочее время компании. Пожалуйста, выберите другое.';
                    break;
                  case 'order':
                    this.reason = 'Время занято заказом. Пожалуйста, выберите другое.';
                    break;
                  case 'notime':
                    this.reason = 'Введите время!';
                    break;
                };
                break;
            };



            kalendarSubmit.addClass('is-disabled');
          }
        });
    },

    weekPickerInit() {
      let vm = this;
      let startDate;
      let endDate;
      let selectCurrentWeek = function() {
        window.setTimeout(function () {
          $('.week-picker')
          .find('.ui-state-active')
          .closest('tr').find('a').addClass('ui-state-active');
        }, 1);
      }

      console.log($('.week-picker').find('.ui-datepicker'));

      $('.week-picker').datepicker({
        firstDay: 1,
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
        showOtherMonths: true,
        selectOtherMonths: true,
        onSelect: function(dateText, inst) {
          let date = $(this).datepicker('getDate');
          startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 1);
          endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
          let dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;

          console.log('startDate', startDate);
          console.log('endDate', endDate);

          vm.startOfWeek = $.datepicker.formatDate( dateFormat, startDate, inst.settings );
          vm.endOfWeek = $.datepicker.formatDate( dateFormat, endDate, inst.settings );

          vm.tableRender();

          $('#startDate').text(this.startOfWeek);
          $('#endDate').text(this.endOfWeek);

          selectCurrentWeek();

          $(this).find('.ui-datepicker').hide();
        },
          beforeShowDay: function(date) {
              let cssClass = '';
              if( date >= startDate && date <= endDate ) 
                  cssClass = 'ui-datepicker-current-day';
              return [true, cssClass];
          },
          onChangeMonthYear: function(year, month, inst) {
              selectCurrentWeek();
          }
      });
      $('.week-picker .ui-datepicker-calendar tr')
      .on('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
      $('.week-picker .ui-datepicker-calendar tr')
      .on('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
    },

    checkEmail(e) {
      let $emailInput = $(e.target);
      let emailVal = $emailInput.val();

      let data = {
        email: emailVal
      };
      
      let isCurrentEmail = lib.validateEmail(emailVal);

      if (!isCurrentEmail) {
        this.checkboxShow = false;
        return;
      }

      console.log('email', data);

      ajax.checkEmail(data)
        .done((res) => {
          if ($.isPlainObject(res)) {
            this.editCart = res;
            this.fillTerminForm();
            this.checkboxShow = false;
            this.emailIsset = false;
          } else if (res == 1) {
            this.checkboxShow = false;
            this.emailIsset = true;
          } else {
            this.checkboxShow = true;
            this.emailIsset = false;
          }
        });
    },

    openModalTdClick(e) {
      let modal = $('[data-remodal-id="kalendarModal"]').remodal();
      let $timeFrom = $('.kalendar-form__timepicker--from');
      let $timeTo = $('#timeTo');
      let $datepicker = $('.kalendar-form__datepicker');
      let isEmpl = $('input[name="employee_id"]').val();

      let $this = $(e.target);
      let time = $this.attr('data-time');
      let date = $this.attr('data-date');

      this.showTab2 = true;
      this.showTab1 = true;
      this.optionShow = false;

      this.action = 'create';
      this.employeeId = $('.kalendar-carousel__block.is-active').attr('data-employee-id');

      if (isEmpl) {
        this.employeeId = isEmpl;
      }

      modal.open();
      this.editCart.time_from = time;
      $datepicker.val(date);
      this.dateEmpl = date;
      this.emailIsset = false;

      // this.getRangeTime();
      this.showServices();

      this.editCart = {};
      $timeTo.val('');
      this.setAllEmployees();
      this.checkboxShow = false;
      this.showEreignisError = false;
      this.showDateEreignis = true;
      this.resetTerminForm();
      this.resetEreignisForm();
      this.editCart.time_from = time;
      $timeFrom.val(time);
      $('#timeFrom').trigger('change');
    },

    openModalBtnClick(e) {
      let modal = $('[data-remodal-id="kalendarModal"]').remodal();
      let $timeFrom = $('#timeFrom');
      let $timeTo = $('#timeTo');
      let $datepicker = $('.kalendar-form__datepicker');

      let $this = $(e.target);
      let time = $this.data('time');
      let date = $this.data('date');

      this.duration = $('#kalService').find('option:selected').attr('data-duration');

      this.showTab2 = true;
      this.showTab1 = true;
      this.employeeId = null;

      this.action = 'create';

      modal.open();
      $timeFrom.val(time);
      $timeTo.val(time);
      $('[data-tab="tab-1"]').click();
      this.emailIsset = false;

      this.kalendarDisabled = false;
      $('#kalendarSubmit').removeClass('is-disabled');

      this.editCart = {};

      this.getServices()
        .done(() => {
          this.optionShow = true;
        });

      this.setAllEmployees();

      this.checkboxShow = false;
      this.showEreignisError = false;
      this.showDateEreignis = true;
      this.resetTerminForm();
      this.resetEreignisForm();
    },

    showServices(id = this.employeeId) {
      let data = {
        employee_id: +this.employeeId
      };

      ajax.getServices(data)
        .done((services) => {
          this.services = services;
          this.duration = $('#kalService').find('option:selected').attr('data-duration');
          $('#timeFrom').trigger('change');
        });
    },

    getServices() {
      let isEmpl = $('input[name="employee_id"]').val();
          let serviceData = {};

          console.log('isEmpl', isEmpl);

          if (isEmpl) {
            serviceData = {
              employee_id: isEmpl
            };
          }

    return ajax.getServices(serviceData)
        .done((services) => {
          this.services = services;

          for (let service in this.services) {
            this.duration = this.services[service][0].duration;
            break;
          }

        });
    },

    sendKalendarForm() {
      let vm = this;
      let form = $('#terminForm');

      form.validate();

      let isValid = form.valid();

      if (isValid) {
        switch (vm.action) {
          case 'create': vm.sendCreate(); break;
          case 'edit': vm.sendEdit(); break;
        }
      }

      
      
    },

    sendEreignisForm() {
      switch (this.action) {
        case 'create': this.sendEreignis(); break;
        case 'edit': this.editEreignis(); break;
      }
    },

    checkTime(start, end) {
      let isCheck = lib.validateTime(start, end);
      let $form = $('#ereignisForm');
      let $timeFrom = $form.find('.kalendar-form__timepicker--from');
      let $timeTo = $form.find('.kalendar-form__timepicker--to');

      if (!isCheck) {
        $timeFrom.addClass('errorFormValid');
        $timeTo.addClass('errorFormValid');
      } else {
        $timeFrom.removeClass('errorFormValid');
        $timeTo.removeClass('errorFormValid');
      }
    },

    sendEreignis() {
      let $form = $('#ereignisForm');
      let data = ajax.getFormData($form);

      $('#tablePreloader').show();

      console.log('dataSendEreignis', data);

      console.log('dataForm', data);
      ajax.sendHoliday(data)
        .done((createRes) => {
          console.log('createRes', createRes);
          $('#tablePreloader').hide();

          if (createRes.check == false) {
            this.showEreignisError = true;
            return;
          }

          if (createRes) {
            this.$root.closeModal();
            this.tableRender();
          } else {
            this.checkTime(this.timeFromEreignis, this.timeToEreignis);
          }
        })
        .fail(() => {
          $('#tablePreloader').hide();
        });
    },

    sendCreate() {
      let $form = $('#terminForm');
      let data = ajax.getFormData($form);

      $('#tablePreloader').show();

      console.log('dataForm', data);
      ajax.sendForm(data)
        .done((createRes) => {
          console.log('createRes', createRes);
          $('#tablePreloader').hide();

          if (createRes) {
            this.$root.closeModal();
            this.tableRender();
          }

          $(`.kalendar-carousel__block[data-employee-id="${this.employeeId}"]`).click();
        })
        .fail(() => {
          $('#tablePreloader').hide();
        });
    },

    sendEdit() {
      let $form = $('#terminForm');
      let data = ajax.getFormData($form);
      let isEdit = confirm('Sind sie sicher?');

      if (!isEdit) return;

      $('#tablePreloader').show();

      data.cartId = this.editCart.id;

      console.log('dataForm', data);
      ajax.sendForm(data)
        .done((editRes) => {
          console.log('editRes', editRes);

          $('#tablePreloader').hide();

          if (editRes) {
            this.$root.closeModal();
            this.tableRender();
          }
        })
        .fail(() => {
          $('#tablePreloader').hide();
        });
    },

    editEreignis() {
      let $form = $('#ereignisForm');
      let data = ajax.getFormData($form);
      let isEdit = confirm('Sind sie sicher?');

      if (!isEdit) return;

      $('#tablePreloader').show();

      data.cartId = this.editCart.id;

      console.log('dataFormsssssssssss', data);
      ajax.sendHoliday(data)
        .done((editRes) => {
          console.log('editRes', editRes);

          $('#tablePreloader').hide();


          if (editRes == 1) {
            this.$root.closeModal();
            this.tableRender();
          } else if (editRes.check === false) {
            this.showEreignisError = true;
          }

        })
        .fail(() => {
          $('#tablePreloader').hide();
        });
    },

    sendDelete(e, path) {
      let $btn = $(e.target);
      let $form = $btn.closest('form');
      let idForm = $form.attr('id');
      let data = ajax.getFormData($form);
      let isDelete = confirm('Wirklich löschen?');

      if (!isDelete) return;

      if ( !!(this.editCart.group_id) ) {
        data.groupId = this.editCart.group_id;
      } else {
        data.cartId = this.editCart.id;
      }

      this.action = 'delete';
      data.action = this.action;

      $('#tablePreloader').show();

      console.log('dataForm', data);
      ajax.sendAjax(data, path)
        .done((deleteRes) => {
          console.log('deleteRes', deleteRes);

          $('#tablePreloader').hide();

           if (deleteRes) {
            this.$root.closeModal();
            this.tableRender();
          }
        })
        .fail(() => {
          $('#tablePreloader').hide();
        });
    },

    showEmployees(e) {
      let isEmpl = $('input[name="employee_id"]').val();

      console.log('isEmpl', isEmpl);

        let data = {
         service_id: this.service
      };
      let $el = $(e.target);
      let duration = $el.find(':selected').attr('data-duration');

      this.duration = duration;

      console.log('showEmployeesData', data);

      if (isEmpl) return;

      ajax.getEmployees(data)
        .done((employees) => {
          this.employees = employees;
          this.optionShow = false;
          this.getRangeTime();
        });
      
    },

    setAllEmployees() {
      let isEmpl = $('input[name="employee_id"]').val();
      let data = {};

      console.log('isEmpl', isEmpl);

      if (isEmpl) return;

      return ajax.getEmployees(data)
        .done((employees) => {
          this.employees = employees;
        });
    },

    getDays() {

      switch (this.$root.locale) {
        case 'de':
            moment.updateLocale('en', {
              weekdays : [
                "Mo", "Di", "Mi", "Do", "Fr", "Sa", "So"
              ]
            });
          break;
        case 'en':
          moment.updateLocale('en', {
            weekdays : [
              "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"
            ]
          });
          break;
        case 'ru':
          moment.updateLocale('ru', {
            weekdays : [
              "По", "Вт", "Ср", "Чт", "Пт", "Су", "Во"
            ]
          });
          break;
      }

      return moment.weekdays();
    },

     getStartDayOfWeek(weekInk = 0) {
      return moment().add(weekInk, 'weeks').startOf('isoWeek');
    },

    getEndDayOfWeek(weekInk = 0) {
      return moment().add(weekInk, 'weeks').endOf('isoWeek');
    },

    getWeekArr() {

      let startOfWeek = this.getStartDayOfWeek(this.weekInk);
      let endOfWeek = this.getEndDayOfWeek(this.weekInk);

      this.startOfWeek = startOfWeek;
      this.endOfWeek = endOfWeek;

      let days = [];
      let day =  this.startOfWeek;

      while (day <= this.endOfWeek) {
        days.push(day.format("DD/MM/YYYY"));
        day = day.clone().add(1, 'd');
      }

      return days;
    },

    getCarts(
      startOfWeek = this.getStartDayOfWeek(this.weekInk).format("DD/MM/YYYY"),
      endOfWeek = this.getEndDayOfWeek(this.weekInk).format("DD/MM/YYYY")) {

      this.startOfWeek = startOfWeek;
      this.endOfWeek = endOfWeek;

      let host = window.location.host;
      let subDomain = host.slice(0, host.indexOf('.'));
      let id = this.employeeId;
      let data = {
        data : subDomain,
        from: this.startOfWeek,
        to: this.endOfWeek,
        id: id
      };


      return ajax.carts(data);
    },

    tableRender(weekInk) {
      let vm = this;

      this.dates = this.getWeekArr();

      this.getCarts()
      .done((carts) => {
        let $tableKal = $('.table-kal');
        let $tables = $tableKal.find('table:not(:first)');
        let $td = $tableKal.find('td');

        $td.empty();

        console.log('current weekDates', this.dates);

        this.carts = carts;

      carts.forEach((cart, i) => {
        let color = cart.color;
        let desc = cart.description;
        let name = cart.name;
        let firstName = cart.first_name;
        let lastName = cart.last_name;
        let date = cart.date;
        let id = cart.id;
        let serviceName = cart.service_name;
        let email = cart.email;
        let days = cart.days;

        let timeFrom = cart.time_from;
        let timeTo = cart.time_to;

        let hourFrom = timeFrom.slice( 0, timeFrom.indexOf(':') );
        let hourTo = timeTo.slice( 0, timeTo.indexOf(':') );
        let minFrom = timeFrom.slice( timeFrom.indexOf(':') + 1 );
        let minTo = timeTo.slice( timeTo.indexOf(':') + 1 );

        let comHour = (hourTo - hourFrom) * 60;
        let comMin = minTo - minFrom;
        let comTime = (comHour + comMin) / 15;


        $tables.each(function(i) {
          let $table = $(this);
          let $th = $table.find('th');
          let thDate = $th.attr('data-date');
          let serviceTran = LOCALES[vm.$root.locale].all.service;
          let descTran = LOCALES[vm.$root.locale].all.desc;

          if(date == thDate) {

            let $tdFrom = $table.find(`[data-time="${timeFrom}"]`);
            let cart = `
              <div
                data-cart-id="${id}"
                style="
                color: #fff;
                background: ${color};
                height: ${(comTime +1) * 20}px;
                "
              class="cart"
              >
                  <time class="cart__item">${timeFrom} - ${timeTo}</time>
                  <div class="cart__item">${firstName} ${lastName}</div>
                  <div>${serviceTran}:</div>
                  <div class="cart__item">${serviceName}</div>
                  <div>${descTran}:</div>
                  <div class="cart__item">${desc}</div>
              </div>
            `;

            let cartRest = `
              <div
                data-cart-id="${id}"
                style="
                color: #fff;
                background: ${color};
                height: ${(comTime +1) * 20}px;
                width: ${100 * days}%;
                "
              class="cart"
              >
                  <time class="cart__item">${timeFrom} - ${timeTo}</time>
                  <div>Description:</div>
                  <div class="cart__item">${desc}</div>
              </div>
            `;

            if (email) {
              $tdFrom.html(cart);
            } else {
              $tdFrom.html(cartRest);
            }

          }
        });

      });

        this.setNoWorkDays();

      })
      .fail(( jqXHR, textStatus ) => {
        // location.reload();
        // throw new Error("Request failed: " + textStatus);
      });
    }

  }
  
  });

  export default KalendarVue;

  

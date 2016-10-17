import Vue from 'vue'
import * as ajax from '../ajax.js'
import filters from '../filters.js'
import WorkTimesVue from './WorkTimesVue.vue'

//PAGINATED
function refreshCategoryEvents() {
    $('#category-table').siblings('.pager').remove();
    $('#category-table').each(function () {
        var currentPage = 0;
        var numPerPage = 15;
        var $table = $(this);
        $table.bind('repaginate', function () {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertAfter($table).find('span.page-number:first').addClass('active');
    });

    // $("#category-table").tablesorter();
}
;
function refreshServicesEvents() {
    $('#services-table').siblings('.pager').remove();
    $('#services-table').each(function () {
        var currentPage = 0;
        var numPerPage = 15;
        var $table = $(this);
        $table.bind('repaginate', function () {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertAfter($table).find('span.page-number:first').addClass('active');
    });

    // $("#services-table").tablesorter();
}
;

let ServicesVue = Vue.component('services-vue', {
	template: '#services-template',

  components: {WorkTimesVue},

  data() {
  	return {
      categories: [],
  		services: [],
      serviceBtn: false,
      categoryBtn: true,
      editCategory: '',
      editService: {
        duration: 5
      },
      canCreate: true,
      showServiceDanger: false,
  	}
  },

  ready() {
    this.getLists();
    this.tableSortedInit();
    this.timePickerInit();
  },

  methods: {

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

      $.timepicker.setDefaults($.timepicker.regional[this.$root.locale]);

      $('.worktime-timepicker').timepicker({
        stepMinute: 5,
        defaultValue: '00:00',
        hourMax: 23
      });
    },

    getWorktimes() {
      this.$broadcast('getWorktimes');
    },

    getLists() {
      let path = `${ajax.LOCPATH}/get_category_services`;

      ajax.sendAjax({}, path)
        .done((data) => {
          console.log('Lists', data);
          this.categories = data.categoryList;
          this.services = data.servicesList;
          this.canCreate = data.can_create;
        });
    },

    tableSortedInit() {
      setTimeout(() => {
        $("#category-table").trigger("destroy").tablesorter();
        $("#services-table").trigger("destroy").tablesorter();
        refreshCategoryEvents();
        refreshServicesEvents();
      }, 1000);
    },

    deleteCategory(category) {
      let data = {id: category.id};
      let path = `${ajax.LOCPATH}/removecategory`;

      ajax.sendAjax(data, path)
        .done((res) => {
          if (res) {
            this.categories.$remove(category);
            this.tableSortedInit();
          }
        });
    },

    deleteService(service) {
      let data = {id: service.service_id};
      let path = `${ajax.LOCPATH}/removeservice`;

      console.log(data);
     
      ajax.sendAjax(data, path)
        .done((res) => {
          if (res) {
            this.services.$remove(service);
            this.canCreate = true;
            this.tableSortedInit();
          }
        });
    },

    openCategoryModal(elemId, category) {
      let modal = $(`#${elemId}`).remodal();
      modal.open();
      this.getLists();
      this.tableSortedInit();
      this.editCategory = '';

      if (category) {
        this.editCategory = category;
      }

    },

    openServiceModal(elemId, service) {
      let modal = $(`#${elemId}`).remodal();
      modal.open();
      this.getLists();
      this.tableSortedInit();
      this.editService = '';

      if (service) {
        this.editService = service;

        this.editService.duration = this.convertToHM(+this.editService.duration);
      }
    },

    convertToHM(minutes) {
      let min = +minutes % 60;
      let hours = Math.floor(+minutes / 60);
      let result;

      if (min < 10) {
        min = `0${min}`;
      }

      if (hours < 10) {
        hours = `0${hours}`;
      }

      return result = `${hours}:${min}`;
    },

    convertToMinutes(duration) {
      duration = duration.split(':');
      duration = (+duration[0] * 60) + (+duration[1]);

      return duration;
    },

    sendCategoryForm(e) {
      let $form = $(e.target);

      if (this.editCategory.id) {
        let path = `${ajax.LOCPATH}/editcategory`;
        let data = ajax.getFormData($form);
        data.id = this.editCategory.id;

        ajax.sendAjax(data, path)
          .done((res) => {
            if (res) {
              $('.remodal-close').trigger('click');
              this.getLists();
              this.tableSortedInit();
            }
          });
      } else {
        let path = `${ajax.LOCPATH}/createcategory`;
        let data = ajax.getFormData($form);

        ajax.sendAjax(data, path)
          .done((res) => {
            if (res) {
              $('.remodal-close').trigger('click');
              this.getLists();
              this.tableSortedInit();
            }
          });
      }
      
    },

    sendServiceForm(e) {
      let $form = $(e.target);

      if (this.editService.service_id) {
        let path = `${ajax.LOCPATH}/editservice`;
        let data = ajax.getFormData($form);
        data.id = this.editService.service_id;
        let duration = data.duration;

        data.duration = this.convertToMinutes(duration);

        ajax.sendAjax(data, path)
          .done((res) => {
            if (res) {
              $('.remodal-close').trigger('click');
              this.getLists();
              this.tableSortedInit();
              this.showServiceDanger = false;
            } else {
              this.showServiceDanger = true;
              setTimeout(() => {
                this.showServiceDanger = false;
              }, 5000);
            }
          });
      } else {
        let path = `${ajax.LOCPATH}/createservice`;
        let data = ajax.getFormData($form);
        let duration = data.duration;

        data.duration = this.convertToMinutes(duration);

        ajax.sendAjax(data, path)
          .done((res) => {
            if (res) {
              $('.remodal-close').trigger('click');
              this.getLists();
              this.tableSortedInit();
            } else {
              this.showServiceDanger = true;
              setTimeout(() => {
                this.showServiceDanger = false;
              }, 5000);
            }
          });
      }
      
    },

    showCategoryBtn() {
      this.categoryBtn = true;
      this.serviceBtn = false;
    },
    showServiceBtn() {
      this.categoryBtn = false;
      this.serviceBtn = true;
    },

  },

  filters: filters,

});

export default ServicesVue;

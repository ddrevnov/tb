import Vue from 'vue'

let EmployeesListVue = Vue.component('employees-list-vue', {
  template: '#employees-list-template',

  data() {
    return {

    }
  },

  ready() {

  },

  methods: {
    deleteEmployee(link) {
      let text = '';
      let isConfirm;
      let locale = this.$root.locale;

      switch (locale) {
        case 'ru':
          text = 'Вы действительно желаете удалить сотрудника? В связи с этим будут удалены все  заказы. вы согласны с этим?';
          break;
        case 'de':
          text = 'Sind Sie sicher, dass Sie einen Mitarbeiter zu löschen? In diesem Zusammenhang werden alle Aufträge gelöscht. gehen Sie mit dem zustimmen?';
          break;
        case 'en':
          text = 'Are you sure you want to delete an employee? In this regard, all orders will be deleted. do you agree with that?';
          break;
      }

      isConfirm = confirm(text);

      if (isConfirm) {
        location.href = link;
      }
    }
  }

});

export default EmployeesListVue;
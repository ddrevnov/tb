import Vue from 'vue'

let TariffsVue = Vue.component('tariffs-vue', {
	template: '#tariffs-tamlate',

  data() {
    return {
      lettersCount: '',
      employeeCount: '',
      servicesCount: '',
      dashboardCount: '',
      lettersUnlimited: false,
      employeeUnlimited: false,
      servicesUnlimited: false,
      dashboardUnlimited: false,
      selectedTarif: ''
    }
  },

  ready() {
    
  },

  methods: {
    checkTable(e) {
      let $el = $(e.target);

      if (this.lettersUnlimited) {
        this.lettersCount = '';
      }
      if (this.employeeUnlimited) {
        this.employeeCount = '';
      }
      if (this.servicesUnlimited) {
        this.servicesCount = '';
      }
      if (this.dashboardUnlimited) {
        this.dashboardCount = '';
      }
    }
  }
});

export default TariffsVue;
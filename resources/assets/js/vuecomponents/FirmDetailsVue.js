import Vue from 'vue'
import * as ajax from '../ajax.js'
import { GET_COUNTRIES, GET_STATES, GET_CITIES } from '../mixins.js'
import WorkTimesVue from './WorkTimesVue.vue'

let FirmDetailsVue = Vue.component('firmdetails-vue', {
	template: '#firmdetails-template',

  components: {WorkTimesVue},

  mixins: [GET_COUNTRIES, GET_STATES, GET_CITIES],

  data() {
    return {
     editingInfo: {},
     countries: [],
     states: [],
     cities: []
    }
  },

  ready() {
    this.getFirmDetailsInfo()
      .done(() => {
        this.getCountries();
        this.getStates(this.editingInfo.country_id);
        this.getCities(this.editingInfo.state_id);
      });
  },

  methods: {

    getWorktimes() {
      this.$broadcast('getWorktimes');
    },

    openModal() {
      this.$root.openModal('#firmDetailsModal');
    },

    getFirmDetailsInfo() {
      let path = `/${ajax.pathWho}/get_firm_details`;
        return ajax.sendAjax({}, path)
          .done((firmDetails) => {
            this.editingInfo = firmDetails;
        });
    },

  }
});

export default FirmDetailsVue;
import Vue from 'vue'
import * as ajax from '../ajax.js'
import { GET_COUNTRIES, GET_STATES, GET_CITIES } from '../mixins.js'

let BillingVue = Vue.component('billing-vue', {
	template: '#billing-template',

  mixins: [GET_COUNTRIES, GET_STATES, GET_CITIES],

  data() {
    return {
        bankDetails: {},
        countries: [],
        states: [],
        cities: []
      }
    
  },

  ready() {
    this.getBankDetails()
      .done(() => {
        this.getCountries();
        this.getStates(this.bankDetails.legal_country);
        this.getCities(this.bankDetails.legal_state);
      });
  },

  methods: {

    openBankModal() {
      this.$root.openModal('#billingBankModal');
      if (this.bankDetails.agreement == 0) {
        this.bankDetails = {};
      }
    },

    refusal() {
      let path = `/${ajax.pathWho}/billing/refusal`;
      let data = {};

      ajax.sendAjax(data, path)
        .done((res) => {
          if (res) {
            this.bankDetails.account_owner = '';
            this.bankDetails.account_number = '';
            this.bankDetails.bank_code = '';
            this.bankDetails.bank_name = '';
            this.bankDetails.iban = '';
            this.bankDetails.bic = '';
            this.bankDetails.agreement = 0;
          }
        });
    },

    openAdressModal() {
      this.$root.openModal('#billingAdressModal');
    },

    getBankDetails() {
      let vm = this;
      let path = `/${ajax.pathWho}/billing/get_bank_details`;
      let data = {};

      return ajax.sendAjax(data, path)
        .done((bankDetails) => {
          if (bankDetails) {
            vm.bankDetails = bankDetails;
          }
        });
    },

    setBankDetails(formStr) {
      let path = `/${ajax.pathWho}/billing/set_bank_details`;
      let data = ajax.getFormData($(`${formStr}`));
      let $form = $('#billingAdressForm');
      let isValidForm = $form.valid();

      if (isValidForm) {
        ajax.sendAjax(data, path)
          .done((res) => {
            if (res) {
              this.$root.closeModal('#billingAdressModal');
              this.$root.closeModal('#billingBankModal');
              this.getBankDetails();
            }
          });
      }

    }

  }
});

export default BillingVue;
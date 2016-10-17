import Vue from 'vue'
import * as ajax from '../ajax.js'
import Alert  from './vue-strap/src/Alert.vue'
import ConfirmVue  from './ConfirmVue.vue'

let TariffVue = Vue.component('tariff-vue', {
	template: '#tariff-temlate',

  components: { Alert, ConfirmVue },

  data() {
    return {
      tariffs: [],
      selectedTariff: {},
      showDangerTarif: false,
      selectedTariffId: null,
      dangerReason: '',
      showConfirmChangeTariff: false,
      isConfirmChangeTariff: false,
      isAgreeChangeTariff: false,
      showAgree: false,
      isDisabled: false
    }
  },

  ready() {
    this.getTariffs();
  },

  methods: {

    freeze() {
      let path = `/${ajax.pathWho}/tariff/freeze`;
      let data = {};

      ajax.sendAjax(data, path)
        .done((isFreeze) => {
          if (isFreeze) {
            this.$root.openModal('#freezeAlertModal');
            $('#freezeAlertModal').addClass('animated bounce');
          }
        });
    },

    getTariffs() {
      let path = `/${ajax.pathWho}/tariff/get_tariffs`;
      let data = {};

      ajax.sendAjax(data, path)
        .done((tariffs) => {
          this.tariffs = tariffs;
          this.selectedTariff = tariffs[0];
          this.selectedTariffId = tariffs[0].id;
        });
    },

    getSelectedTariff() {
      let selectedTariff = this.tariffs.filter((tariff) => {
        return this.selectedTariffId === tariff.id;
      });

      this.selectedTariff = selectedTariff[0];
    },

    setNewTariff() {

      if (!this.isAgreeChangeTariff) {
        this.showAgree = true;
        this.isConfirmChangeTariff = true;
        this.isDisabled = true;
        return;
      }

      this.showConfirmChangeTariff = true;
      this.showAgree = false;
      this.isDisabled = false;

      if (!this.isConfirmChangeTariff) {
        this.isConfirmChangeTariff = false;
        this.isAgreeChangeTariff = false;
        return;
      }

    },

    step2() {
      $('.block__nav').find('[data-tab="tab-2"]').click();
    }

  },

  watch: {

    //isAgreeChangeTariff() {
    //  if (this.isAgreeChangeTariff) {
    //    this.isDisabled = false;
    //  } else {
    //    this.isDisabled = true;
    //  }
    //}
  },

  events: {
    changeTariff() {
      if (this.isConfirmChangeTariff) {
        let path = `/${ajax.pathWho}/tariff/change`;
        let data = {
          id: this.selectedTariffId
        };

        this.isConfirmChangeTariff = false;

        ajax.sendAjax(data, path)
          .done((res) => {
            this.showConfirmChangeTariff = false;
            this.showAgree = false;
            this.isAgreeChangeTariff = false;

            if (res.status) {
              location.reload();
            } else {
              this.dangerReason = res.reason;
              this.showDangerTarif = true;
              this.showAgree = false;
              this.isAgreeChangeTariff = false;
              this.isConfirmChangeTariff = false;
              this.isDisabled = false;
            }
          });
      } else {
        this.showAgree = false;
        this.isAgreeChangeTariff = false;
        this.isDisabled = false;
      }
    }
  }
  
});

export default TariffVue;
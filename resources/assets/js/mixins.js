import * as ajax from './ajax.js';

export const countries = {
  methods: {
  	getCountries() {
      let path = `/${ajax.pathWho}/get_location`;

      ajax.sendAjax({}, path)
        .done((countries) => {
          this.countries = countries;
          this.getStates();
        });
    },

    getStates() {
      let path = `/${ajax.pathWho}/get_location`;
      let data = {
        country_id: this.editingInfo.country_id
      };

      $('#tablePreloader').show();

      ajax.sendAjax(data, path)
        .done((states) => {
          this.states = states;
          this.getCities();
          $('#tablePreloader').hide();
        })
        .error(() => {
          $('#tablePreloader').hide();
        });
    },

    getCities() {
      let path = `/${ajax.pathWho}/get_location`;
      let data = {
        state_id: this.editingInfo.state_id
      };

      $('#tablePreloader').show();

      ajax.sendAjax(data, path)
        .done((cities) => {
          this.cities = cities;
          $('#tablePreloader').hide();
        })
        .error(() => {
          $('#tablePreloader').hide();
        });
    },
  }
};


export const GET_COUNTRIES  = {
  methods: {
    getCountries() {
      let path = `/${ajax.pathWho}/get_location`;

      ajax.sendAjax({}, path)
        .done((countries) => {
          this.countries = countries;
        });
    },
  }
};

export const GET_STATES  = {
  methods: {
    getStates(id) {
      let path = `/${ajax.pathWho}/get_location`;
      let data = {
        country_id: id
      };

      $('#tablePreloader').show();

      ajax.sendAjax(data, path)
        .done((states) => {
          this.states = states;
          $('#tablePreloader').hide();
        })
        .error(() => {
          $('#tablePreloader').hide();
        });
    },
  }
};

export const GET_CITIES  = {
  methods: {
    getCities(id) {
      let path = `/${ajax.pathWho}/get_location`;
      let data = {
        state_id: id
      };

      $('#tablePreloader').show();

      ajax.sendAjax(data, path)
        .done((cities) => {
          this.cities = cities;
          $('#tablePreloader').hide();
        })
        .error(() => {
          $('#tablePreloader').hide();
        });
    },
  }
};
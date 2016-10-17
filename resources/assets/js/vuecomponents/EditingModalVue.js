import Vue from 'vue';
import * as ajax from '../ajax.js';
import {countries} from '../mixins.js';

let EditingModalVue = Vue.component('editing-modal-vue', {
	template: '#editing-modal-template',

  data() {
  	return {
  		editingInfo: [],
      countries: [],
      states: [],
      cities: [],
      errors: {
        password: false,
        email: false
      },
      genders: [
        {value: 'male', text: 'Male'},
        {value: 'female', text: 'Female'}
      ],
      groups: [
        {value: 'employee', text: 'Employee'},
        {value: 'admin', text: 'Admin'}
      ],
      emailSends: [
        {value: 0, text: 'Not Send'},
        {value: 1, text: 'Send'}
      ],
      statuses: [
        {value: 'active', text: 'Active'},
        {value: 'notactive', text: 'Not active'},
        {value: 'blocked', text: 'Blocked'},
        {value: 'freeze', text: 'Freeze'}
      ]
  	}
  },

  ready() {
    
  },

  mixins: [countries],

  methods: {

  	closeModal() {
      this.$dispatch('closeModal');
    },

  	getEditingInfo() {
      let path = `${ajax.LOCPATH}/get_personal_info`;

  			ajax.sendAjax({}, path)
  				.done((editingInfo) => {
  					console.log('editingInfo', editingInfo);
  					this.editingInfo = editingInfo;
            this.getCountries();
  				});
  	},

    // Проверка на валидность находиться в Validate.js

  },

  events: {
    openUserInfoModal() {
      let modal = $('#userInfoModal').remodal();
      modal.open();
      this.getEditingInfo();
    }
  }

});

export default EditingModalVue;

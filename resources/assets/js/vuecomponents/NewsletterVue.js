import Vue from 'vue'
import * as ajax from '../ajax.js'

let NewsletterVue = Vue.component('newsletter-vue', {
  template: '#newsletter-template',

  data() {
    return {

    }
  },

  ready() {

  },

  methods: {

      preview() {
        $('#cke_19').click();
      }

  }

});

export default NewsletterVue;
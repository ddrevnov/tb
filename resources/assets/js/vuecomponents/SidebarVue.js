import Vue from 'vue'
import * as ajax from '../ajax.js'

let SidebarVue = Vue.component('sidebar-vue', {
	template: '#sidebar-template',

  data() {
    return {
      
    }
  },

  ready() {
    let $links = $('.sidebar__item a');
    $links.each((i, el) => {
    	let $link = $(el);
    	let href = el.href;

    	if (href === `${location.href}`) {
    		$link.closest('.sidebar__item').addClass('is-active');
    	}
    	
    });
  },

  methods: {

  }
});

export default SidebarVue;
import Vue from 'vue'
import moment from 'moment'
import * as ajax from '../ajax.js'
import {SOCKET, MYID} from '../lib.js'

let ChatVue = Vue.component('chat-vue', {
	template: '#chat-template',

  data() {
    return {
    	userId: null,
    	showContact: false,
    	text: '',
      userMessages: [],
      myId: MYID,
      showPrevBtn: false,
      countMess: null,
      searchPosition: -1,
      searchName: '',
      headingsLen: null
    };
  },

  ready() {
    let vm = this;

    vm.socketInit();
  	vm.accordionInit();
    vm.highlightNewMess();

    let comerId = ajax.LOCPATH.substr(ajax.LOCPATH.lastIndexOf('/') + 1);

    if ($.isNumeric(comerId)) {
      let $fromItem = $(`#${comerId}`);
      let $heading = $fromItem.closest('.ui-accordion-content').prev().first();
      let $countMess = $('.search__send .search__count');

      if (+$countMess.text() !== 0) {
        let allCount = +$countMess.text();
        let newCount = allCount - 1;
        
        $countMess.text(newCount);
      }

      if (!$heading.hasClass('ui-accordion-header-active')) {
        $heading.click();
      }

      $fromItem.click();
    }

  },

  methods: {

    highlightNewMess() {
      let $lists = $('.ui-accordion-content');

      $lists.each((i, el) => {
        let countNum = 0;
        let $list = $(el);
        let $counts = $list.find('.contacts__count');

        $counts.each((i, el) => {
          let $count = $(el);
          countNum += +$count.text();
        });

        if (countNum > 0) {
          $list.prev('.ui-accordion-header').addClass('not-read');
        } else {
          $list.prev('.ui-accordion-header').removeClass('not-read');
        }
      });
    },

  	accordionInit() {
	    $( "#chatAccordion" ).accordion({
	      active: false,
	      collapsible: true,
        heightStyle: 'content'
	    });
  	},

    socketInit() {
      let vm = this;
      let dataUserId = {
        data: {
          userId: MYID
        }
      };

      SOCKET.emit('regUser', dataUserId);
      
      SOCKET.on('new_message', function (data) {
        console.log('newMessage data', data);
        data.created_at = moment().format('YYYY-MM-DD HH:mm:ss');

        let $fromItem = $(`#${data.from}`);

        let $time = $fromItem.find('.contacts__time');
        let $text = $fromItem.find('.contacts__text');

        $time.text(data.created_at);
        $text.text(data.text);

        vm.sendAjaxUser();

        if (vm.userId == data.from) {
          vm.userMessages.messages.push(data);
        } else {
          let $fromCount = $fromItem.find('.contacts__count');
          let fromCountNumber = +$fromCount.text();
          $fromCount.text(fromCountNumber + 1);
        }

        vm.highlightNewMess();
        vm.scrollToBottom();
      });
    },

    prevBtnHandler() {
      this.showPrevBtn = (this.userMessages.length > 10);
      this.countMess += 1;
      this.sendAjaxUser();
    },

    searchUsers(e) {
      let vm = this;
      let $input = $(e.target);
      let searchName = $input.val();
      let $accordion = $('#chatAccordion');
      let $headings = $accordion.find('.avatar__heading');

      vm.headingsLen = $headings.length;
      vm.searchName = searchName.toUpperCase();

      if (vm.searchName.length < 3) return;

      $headings.each((i, el) => {
        let $el = $(el);
        let userName = $el.text().toUpperCase();

        vm.headingsLen -= 1;

        if (vm.headingsLen === 0 && vm.searchPosition !== -1) {
          vm.searchPosition = -1;
          vm.headingsLen = null;
          vm.searchUsers(e);
        }

        // continue iteration
        if (vm.searchPosition >= i) {
          return true;
        }

        if( userName.indexOf(vm.searchName) > -1 ) {
          let $heading = $el.closest('.ui-accordion-content').prev().first();
          

          if (!$heading.hasClass('ui-accordion-header-active')) {
            $heading.click();
          }
          
          $el.closest('.eingang__item').click();

          vm.searchPosition = i;

          return false;
        }

      });
      
    },

    onEnterMess() {
      $('#sendMessBtn').trigger('click');
    },

    scrollToBottom() {
      $('.contact__block-wrap').animate({ 
        scrollTop: $('.contact__block-wrap').prop("scrollHeight")
      }, 1000);
    },

  	showMessage(e) {
  		let userId = this.userId;
  		let text = (this.text).trim();
      let path = `/${ajax.pathWho}/messages/send_message`;
      let $btn = $(e.target);

  		if (!text) {
  			return;
  		}

  		let data = {
  			userId: userId,
  			text: text,
        from: MYID,
        created_at: moment().format('YYYY-MM-DD HH:mm:ss')
  		};

  		console.log('send data', data);

  		ajax.sendAjax(data, path)
  			.done((res) => {
          $btn.closest('.contact').find('textarea').val('');
          this.userMessages.messages.push(data);
          this.userMessages.length = this.userMessages.length + 1;
          this.scrollToBottom();
  			});
  	},

    sendAjaxUser() {
      let path = `/${ajax.pathWho}/messages/get_user`;

      let dataUserId = {
        userId: this.userId,
        count: this.countMess
      };

      ajax.sendAjax(dataUserId, path)
        .done((messages) => {
          console.log('messages', messages);

          this.userMessages = messages;
          this.highlightNewMess();

          this.$dispatch('newMess');

          if(this.userMessages.messages.length >= this.userMessages.length) {
            this.showPrevBtn = false;
            return;
          } else {
            this.showPrevBtn = (this.userMessages.length > 10);
          }
          
        });
    },

  	getUser(e) {
  		let $el = $(e.target);
      if ( !$el.hasClass('eingang__item') ) {
        $el = $el.closest('.eingang__item');
      };

      let id = +$el.attr('id');
      let $items = $('.eingang__item');


      let name = $el.find('.avatar__heading').text();
      let email = $el.find('.avatar__email').text();
      let imgSrc = $el.find('.avatar__img').attr('src');
      let $contact = $('#contact');
      let $avatar = $contact.find('.avatar img');
      let $avatarHeading = $contact.find('.avatar__heading');
      let $avatarEmail = $contact.find('.avatar__email');

      // Clear count messages
      let $count = $el.find('.contacts__count');
      $count.text('0');

      console.log($avatar);

      $avatar.attr('src', imgSrc);
      $avatarHeading.text(name);
      $avatarEmail.text(email);


      $items.removeClass('is-active');
      $el.addClass('is-active');

      this.userId = id;
			this.showContact = true;
      this.countMess = 1;
      this.sendAjaxUser();
  	}

  }
});

export default ChatVue;
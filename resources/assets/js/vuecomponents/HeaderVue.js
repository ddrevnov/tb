import Vue from 'vue'
import moment from 'moment'
import * as ajax from '../ajax.js'
import filters from '../filters.js'
import {SOCKET, MYID} from '../lib.js'
import HeaderTimeVue from './HeaderTimeVue.vue'

let HeaderVue = Vue.component('header-vue', {
	template: '#header-template',

  filters: filters,
  components: {HeaderTimeVue},

  data() {
    return {
      showUsersPopap: false,
    	showNewAdminsPopap: false,
      showSearchList: false,
      users: [],
      pathWho: ajax.pathWho,
      query: '',
      searchData: {
        admins: [],
        admins_new: [],
        bills: [],
        clients: [],
        employees: [],
        letters: [],
      },
      pathWho: ajax.pathWho,
      notifications: [],
      messCount: 2,
      showMoreNotices: 3,
      showMoreMess: 3,
    }
  },

  ready() {
    this.getNewMess();
    this.socketInit();
    this.getNotifications();

    $(document).click((event) => {
      if ($(event.target).closest(".notice__popup").length ||
          $(event.target).closest(".search-list").length ||
          $(event.target).closest(".mess-popup").length ||
          $(event.target).closest(".search__popup").length) return;
      this.showNewAdminsPopap = false;
      this.showSearchList = false;
      this.showUsersPopap = false;
      event.stopPropagation();
    });
  },

  methods: {

    transitionLink(notice, e) {
      let href = e.target.href;
      let noticeId = notice.id;

      let path = `/${ajax.pathWho}/delete_notice`;
      let data = {
        id: noticeId
      };

      ajax.sendAjax(data, path)
        .done((res) => {
          if (res) {
            window.location.href = href;
          }
        });
    },

    getNotifications() {
      let path = `/${ajax.pathWho}/get_notice`;
      let data = {};

      ajax.sendAjax(data, path)
        .done((notifications) => {
          this.notifications = notifications;
        });
    },

    showUserPopupHandler() {
      this.showUsersPopap = !this.showUsersPopap;
      this.showNewAdminsPopap = false;
    },

    showNewAdminsPopupHandler() {
      this.showNewAdminsPopap = !this.showNewAdminsPopap;
      this.showUsersPopap = false;
    },

    deleteNotice(notice) {
      let noticeId = notice.id;
      let path = `/${ajax.pathWho}/delete_notice`;
      let data = {
        id: noticeId
      };
      ajax.sendAjax(data, path)
        .done((res) => {
          if (res) {
            this.notifications.$remove(notice);
          }
        });
    },


    search() {
      let resource = this.$resource(`/${ajax.pathWho}/search?q=${this.query}`);

      if (this.query.length < 3) {
        this.showSearchList = false;
        return;
      }

      resource.get().then((response) => {
        this.$set('searchData', response.data);
        this.showSearchList = true;
      });
    },

    reset() {
      this.query = '';
      this.searchData = {};
    },

    getNewMess() {
      let path = `/${this.pathWho}/get_new_messages`;

      ajax.sendAjax({}, path)
        .done((newMessages) => {

          if (newMessages === false) {
            this.users = [];
          } else {
            this.users = newMessages;
          }
          
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
        data.created_at = moment().locale(vm.$root.locale).format('YYYY-MM-DD h:mm:ss');

        vm.getNewMess();

        let isUser = vm.users.some((user) => {
          return user.from == data.from;
        });

        if (!isUser) {
          vm.users.push(data);
        }

      });
    },

  },

  events: {
    newMess() {
      this.getNewMess();
    }
  }
});

export default HeaderVue;
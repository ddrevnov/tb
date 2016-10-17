import Vue from 'vue'
import Alert  from './vue-strap/src/Alert.vue'
import PaginationVue  from './PaginationVue.vue'
import filters from '../filters.js'
import * as ajax from '../ajax.js'

let OrdersVue = Vue.component('orders-vue', {
	template: '#orders-template',

  components: { Alert, PaginationVue },

  data() {
    return {
      bankInfo: {},
      legalAddress: {},
      orders: [],
      query: '',
      ordersFrom: '',
      ordersTo: '',
      searchShow: true,
      showSuccess: false,
      showSuccessCancel: false,
      showDanger: false,
      paids: [],
      pageNumber: 1,
      countPages: 0
    }
  },

  filters: filters,

  ready() {
    this.datepickerInit();
    this.getOrders();
  },

  methods: {

    tableSorterInit() {
      $('.orders-table').tablesorter();
    },

    openModal(modalStr = '.remodal') {
      let modal = $(modalStr).remodal();
      modal.open();
    },

    getOrders() {
      let data = {
        page: this.pageNumber
      };
      let path = `/${ajax.pathWho}/orders/get_orders`;
      ajax.sendAjax(data, path)
        .done((res) => {
          this.orders = res.orders;
          this.countPages = res.count;
          this.tableSorterInit();
        });
    },

    cancel(e, i) {
      let path = e.target.href;
      let data = {};

      ajax.sendAjax(data, path)
        .done((res) => {
          if (res) {
            this.orders[i].status = 'cancel';
            this.showSuccessCancel = true;
          }
        });
    },

    sendEmail(e) {
      let href = e.target.href;
      let path = href;

      ajax.sendAjax({}, path)
        .done((res) => {
          if (res) {
            this.showSuccess = true;
          } else {
            this.showDanger = true;
          }
          
        });
    },

    getBankInfo() {
      let path = `/${ajax.pathWho}/orders/get_bank_info`;

      ajax.sendAjax({}, path)
        .done((res) => {
          if (res) {
            this.bankInfo = res;
            this.openModal('#orderModal1');
          }
          
        });
    },

    getLegalAddress() {
      let path = `/${ajax.pathWho}/orders/get_legal_address`;

      ajax.sendAjax({}, path)
        .done((res) => {
          if (res) {
            this.legalAddress = res;
            this.openModal('#orderModal2');
          }
          
        });
    },

    searchOrders() {
      let path = `/${ajax.pathWho}/orders/search`;

      setTimeout(() => {
        let data = {
          q: this.query,
          from: this.ordersFrom,
          to: this.ordersTo
        };

        ajax.sendAjax(data, path)
          .done((orders) => {
            this.orders = orders;
            this.countPages = 0;
            this.tableSorterInit();
          });
      }, 100);
    },

    datepickerInit() {

        $("#ordersFrom").datepicker({
            firstDay: 1,
            dateFormat: "yy-mm-dd",
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#ordersTo").datepicker("option", "minDate", selectedDate);
            }
        });

        $("#ordersTo").datepicker({
            firstDay: 1,
            dateFormat: "yy-mm-dd",
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#ordersFrom").datepicker("option", "maxDate", selectedDate);
            }
        });

    },

    paidHandler(e) {
      let $checkbox = $(e.target);
      let orderId = +$checkbox.closest('tr').attr('data-order-id');
      let issetId;

      if ($checkbox.is(":checked")) {
        issetId = this.paids.some((paid) => {
          return paid === orderId;
        });

        if (issetId) return;
      } else {
        this.paids = this.paids.filter((paid) => {
          return paid !== orderId;
        });

        return;
      }

      this.paids.push(orderId);

    },

    submitPaid() {
      let path = `/${ajax.pathWho}/orders/confirm_order`;
      let data = {
        paid_id: this.paids
      };
      let isOk = confirm('Are you sure?');

      if (!isOk) {
        return;
      };

      ajax.sendAjax(data, path)
        .done((res) => {
          if (res) {

            this.orders.forEach((order, orderIndex) => {
              this.paids.forEach((paid) => {
                if (order.id === paid) {
                  this.orders[orderIndex].status = 'paid';
                  this.orders[orderIndex].paid_at = new Date();
                }
              });

            });

            this.paids = [];


            //this.searchOrders();
          }
        });
    }

  },

  events: {
    getOrders(index) {
      this.pageNumber = index;
      this.getOrders();
    }
  }
});

export default OrdersVue;
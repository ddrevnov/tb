import Vue from 'vue'
import moment from 'moment'
import * as ajax from '../ajax.js'

let DashboardVue = Vue.component('dashboard-vue', {
    template: '#dashboard-template',

    data() {
        return {
            dateFrom: '',
            dateTo: '',
            dashboardInfo: {},
            subdomainSum: 0,
            calendarSum: 0,
            deletedSum: 0,
            clientsSum: 0,
            adminsSum: 0,
            ordersSum: 0,
            emailsSum: 0,

            daysLimitModal: null,
            isFirstShowModal: false,
            days: 0
        }
    },

    ready() {
        this.setDom();
        this.datepickerInit();
        this.getDashboard('currentMonth');
    },

    methods: {

        setDom() {
            this.daysLimitModal = $('[data-remodal-id="modal-days-limit"]').remodal();
        },

        chartInit() {
            let columns, types, colors, groups;
            let subdomainOrdersTxt, calendarOrdersTxt, deletedOrdersTxt, clientsCountTxt, adminsCountTxt, ordersSumTxt, emailsSumTxt;

            switch (this.$root.locale) {
                case 'de':
                    subdomainOrdersTxt = 'Aufträge durch Microsite';
                    calendarOrdersTxt = 'Aufträge';
                    deletedOrdersTxt = 'Stornierte Aufträge';
                    ordersSumTxt = 'GESAMTEINNAHME';
                    emailsSumTxt = 'Anzahl der gesendete E-Mails';
                    clientsCountTxt = 'Anzahl der Kunden';
                    adminsCountTxt = 'Anzahl der Administratoren';
                    break;
                case 'en':
                    subdomainOrdersTxt = 'Orders by microsite';
                    calendarOrdersTxt = 'Assignments';
                    deletedOrdersTxt = 'Cancelled orders';
                    ordersSumTxt = 'TOTAL REVENUE';
                    emailsSumTxt = 'Number of Emails Sent';
                    clientsCountTxt = 'Number of customers';
                    adminsCountTxt = 'Number of administrators';
                    break;
                case 'ru':
                    subdomainOrdersTxt = 'Заказы на сайте';
                    calendarOrdersTxt = 'Контракты';
                    deletedOrdersTxt = 'Отмененные заказы';
                    ordersSumTxt = 'ИТОГО ДОХОДОВ';
                    emailsSumTxt = 'Количество отправленных сообщений';
                    clientsCountTxt = 'Количество клиентов';
                    adminsCountTxt = 'Количество админов';
                    break;
            }

            if (ajax.pathWho === 'backend') {

                let subdomainOrders = (`${subdomainOrdersTxt}, ` + this.dashboardInfo.subdomain_orders.join(', ')).split(', ');
                let calendarOrders = (`${calendarOrdersTxt}, ` + this.dashboardInfo.calendar_orders.join(', ')).split(', ');
                let deletedOrders = (`${deletedOrdersTxt}, ` + this.dashboardInfo.deleted_orders.join(', ')).split(', ');
                let clientsCount = (`${clientsCountTxt}, ` + this.dashboardInfo.clients_count.join(', ')).split(', ');
                let adminsCount = (`${adminsCountTxt}, ` + this.dashboardInfo.admins_count.join(', ')).split(', ');
                columns = [
                    subdomainOrders,
                    calendarOrders,
                    deletedOrders,
                    clientsCount,
                    adminsCount,
                ];

                types = {
                    subdomain_orders: 'area-spline',
                    calendar_orders: 'area-spline',
                    deleted_orders: 'area-spline',
                    clients_count: 'area-spline',
                    admins_count: 'area-spline',
                    // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                };

                colors = {
                    subdomain_orders: '#FF0000',
                    calendar_orders: '#FFFF00',
                    deleted_orders: '#00FF00',
                    clients_count: '#0000FF',
                    admins_count: '#D4A190',
                };

                groups = [['subdomain_orders', 'calendar_orders', 'deleted_orders', 'clients_count', 'admins_count']];


            } else if (ajax.pathWho === 'office') {

                let subdomainOrders = (`${subdomainOrdersTxt}, ` + this.dashboardInfo.subdomain_orders.join(', ')).split(', ');
                let calendarOrders = (`${calendarOrdersTxt}, ` + this.dashboardInfo.calendar_orders.join(', ')).split(', ');
                let deletedOrders = (`${deletedOrdersTxt}, ` + this.dashboardInfo.deleted_orders.join(', ')).split(', ');
                let ordersSum = (`${ordersSumTxt}, ` + this.dashboardInfo.orders_sum.join(', ')).split(', ');
                let emailsSum = (`${emailsSumTxt}, ` + this.dashboardInfo.send_emails.join(', ')).split(', ');
                columns = [
                    subdomainOrders,
                    calendarOrders,
                    deletedOrders,
                    ordersSum,
                    emailsSum
                ];

                types = {
                    subdomain_orders: 'area-spline',
                    calendar_orders: 'area-spline',
                    deleted_orders: 'area-spline',
                    send_emails: 'area-spline',
                    orders_sum: 'area-spline',
                    // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                };

                colors = {
                    subdomain_orders: '#FF0000',
                    calendar_orders: '#FFFF00',
                    deleted_orders: '#00FF00',
                    send_emails: '#0000FF',
                    orders_sum: '#D4A190',
                };

                groups = [['subdomain_orders', 'calendar_orders', 'deleted_orders', 'send_emails', 'orders_sum']];
            }

            var grafic = c3.generate({
                bindto: '#grafic',
                data: {
                    columns: columns,
                    types: types,
                    colors: colors
                },
                tooltip: {
                    show: true,
                    grouped: false,
                    format: {
                        title: function (d) {
                            return null;
                        }
                    },
                    position: function (data, width, height, element) {
                        var chartOffsetX = document.querySelector("#grafic").getBoundingClientRect().left,
                            graphOffsetX = document.querySelector("#grafic g.c3-axis-y").getBoundingClientRect().right,
                            tooltipWidth = document.getElementById('tooltip').parentNode.clientWidth,
                            x = (parseInt(element.getAttribute('cx')) ) + graphOffsetX - chartOffsetX + 10,
                            y = element.getAttribute('cy');

                        y = y - height + 21;

                        return {top: y, left: x}
                    },
                    contents: function (data, defaultTitleFormat, defaultValueFormat, color) {
                        var $$ = this, config = $$.config,
                            titleFormat = config.tooltip_format_title || defaultTitleFormat,
                            nameFormat = config.tooltip_format_name || function (name) {
                                    return name;
                                },
                            valueFormat = config.tooltip_format_value || defaultValueFormat,
                            text, i, title, value;

                        for (i = 0; i < data.length; i++) {
                            if (!(data[i] && (data[i].value || data[i].value === 0))) {
                                continue;
                            }

                            if (!text) {
                                text = "<div id='tooltip' class='d3-tip'>";
                            }
                            value = valueFormat(data[i].value, data[i].ratio, data[i].id, data[i].index);

                            text += "<span class='value'> " + value + " Neue Terminen</span>";
                        }

                        return text;
                    }
                }
            });
        },

        sumArrGraf(arr) {
            let sum = 0;

            arr.forEach((num) => {
                sum += num;
            });

            return sum;
        },

        getDateRange() {
            this.dateTo = moment().format('YYYY-MM-DD');
            this.dateFrom = moment().subtract(30, 'days').format('YYYY-MM-DD');
        },

        getDashboard(all) {
            let path = `/${ajax.pathWho}/get_dashboard`;

            let data = {
                from: '',
                to: ''
            };

            let isAllPeriod = false;


            switch (all) {
                case 'all':
                    this.setAllDateRange();
                    isAllPeriod = true;
                    break;
                case 'currentWeek':
                    this.setCurrentWeekDateRange();
                    break;
                case 'currentMonth':
                    this.setCurrentMonthDateRange();
                    break;
            }

            data = isAllPeriod ? {} : {from: this.dateFrom, to: this.dateTo};

            ajax.sendAjax(data, path)
                .done((res) => {
                    this.dashboardInfo = res;

                    if (ajax.pathWho === 'backend') {

                        if (res.first_data) {
                            this.dateFrom = moment(res.first_data).format('YYYY-MM-DD');
                        }
                        this.subdomainSum = this.sumArrGraf(this.dashboardInfo.subdomain_orders);
                        this.calendarSum = this.sumArrGraf(this.dashboardInfo.calendar_orders);
                        this.deletedSum = this.sumArrGraf(this.dashboardInfo.deleted_orders);
                        this.clientsSum = this.sumArrGraf(this.dashboardInfo.clients_count);
                        this.adminsSum = this.sumArrGraf(this.dashboardInfo.admins_count);
                    } else if (ajax.pathWho === 'office') {
                        if (res.days && this.isFirstShowModal) {
                            this.daysLimitModal.open();
                            this.days = res.days;
                        } else {
                            this.isFirstShowModal = true;
                        }
                        if (res.first_data) {
                            this.dateFrom = moment(res.first_data).format('YYYY-MM-DD');
                        }
                        this.subdomainSum = this.sumArrGraf(this.dashboardInfo.subdomain_orders);
                        this.calendarSum = this.sumArrGraf(this.dashboardInfo.calendar_orders);
                        this.deletedSum = this.sumArrGraf(this.dashboardInfo.deleted_orders);
                        this.ordersSum = this.sumArrGraf(this.dashboardInfo.orders_sum);
                        this.emailsSum = this.sumArrGraf(this.dashboardInfo.send_emails);

                    }

                    this.chartInit();
                });
        },

        setCurrentMonthDateRange() {
            this.dateTo = moment().format('YYYY-MM-DD');
            this.dateFrom = moment().startOf('month').format('YYYY-MM-DD');
        },

        setCurrentWeekDateRange() {
            this.dateTo = moment().format('YYYY-MM-DD');
            this.dateFrom = moment().startOf('isoWeek').format('YYYY-MM-DD');
        },

        setAllDateRange() {
            this.dateTo = moment().format('YYYY-MM-DD');
            this.dateFrom = '';
        },

        datepickerInit() {

            $("#dashboardFrom").datepicker({
                firstDay: 1,
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                maxDate: new Date(),
                onClose: function (selectedDate) {
                    $("#dashboardTo").datepicker("option", "minDate", selectedDate);
                }
            });

            $("#dashboardTo").datepicker({
                firstDay: 1,
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                maxDate: new Date(),
                onClose: function (selectedDate) {
                    $("#dashboardFrom").datepicker("option", "maxDate", selectedDate);
                }
            });

        }
    }
});

export default DashboardVue;
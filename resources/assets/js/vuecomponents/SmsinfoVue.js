import Vue from 'vue'
import * as ajax from '../ajax.js'

let SmsinfoVue = Vue.component('smsinfo-vue', {
    template: '#smsinfo-template',

    props: ['data'],

    data(){
        return {
            dateFrom: '',
            dateTo: '',
            showDetailInfo: false,
            chosenPackage: null,
            withoutTax: 0,
            tax: 0,
            typeOfBuy: 'package',
            countSMS: 0,
            confirmBuy: false,
            totalSMS: 0,
            smsStatistic: [],
            toggleMenuSms: '#1',
            rulesOk: false,
            sepaRules: false,
            generalRules: false,
        }
    },

    computed: {
        tax: function () {
            if (this.chosenPackage) {
                return this.chosenPackage.price * 0.19;
            }
        },
        finalSum: function () {
            if (this.chosenPackage) {
                return parseFloat(this.chosenPackage.price) + parseFloat(this.tax);
            }
        },
        totalSMS: function () {
            return parseInt(this.data.sms_data.sent) + parseInt(this.data.sms_data.count);
        },
        rulesOk: function () {
            if (this.data.bank_details.agreement == '1' && this.sepaRules && this.generalRules) {
                return true;
            } else if (this.data.bank_details.agreement == '0' && this.generalRules) {
                return true;
            }
            return false;
        },
        smsBodyCount: function () {
            return Math.ceil(this.data.sms_data.body.length / 140);
        },
    },

    ready() {
        this.showSMSStatistic('week');
        this.datepickerInit();
        console.log(this.toggleMenuSms);
    },

    methods: {
        chooseSMSPackage(sms_package){
            this.chosenPackage = sms_package;
        },
        calculateSMS(){
            let price = +this.countSMS * 0.09;
            console.log(price);
            this.chosenPackage = {
                package_title: 'Calculate',
                count: this.countSMS,
                price: price
            }
        },
        checkCalculateSMS(){
            if (this.countSMS < 150){
                this.countSMS = 150;
            }
            this.calculateSMS();
        },
        confirmChosen(){
            if (this.showDetailInfo == true) {
                this.buyPackage();
            }
            if (this.chosenPackage) {
                this.showDetailInfo = true;
            }
        },
        buyPackage(){
            if (!this.rulesOk) {
                return;
            }
            let path = `/${ajax.pathWho}/sms/buy`;
            let data = {
                sms_package: this.chosenPackage,
                bank_details: this.data.bank_details,
            };

            ajax.sendAjax(data, path)
                .done((response) => {
                    if (response == true) {
                        this.confirmBuy = true;
                    }
                });
        },
        getDateRange() {
            this.dateTo = moment().format('YYYY-MM-DD');
            this.dateFrom = moment().subtract(30, 'days').format('YYYY-MM-DD');
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
        filterOrdersByDate(){
            let path = `/${ajax.pathWho}/sms/filter_orders`;
            let data = {
                from: this.dateFrom,
                to: this.dateTo,
            };

            ajax.sendAjax(data, path)
                .done((response) => {
                    this.data.orders = response;
                });
        },
        datepickerInit() {

            $("#smsStatFrom").datepicker({
                firstDay: 1,
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                maxDate: new Date(),
                onClose: function (selectedDate) {
                    $("#smsStatTo").datepicker("option", "minDate", selectedDate);
                }
            });

            $("#smsStatTo").datepicker({
                firstDay: 1,
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                maxDate: new Date(),
                onClose: function (selectedDate) {
                    $("#smsStatFrom").datepicker("option", "maxDate", selectedDate);
                }
            });

        },
        changeSMSNotify(){
            let path = `/${ajax.pathWho}/sms/change_notify`;
            let data = this.data.sms_data;

            ajax.sendAjax(data, path)
                .done((response) => {
                    if (response == true) {
                        return location.href = '/office/sms';
                    }
                });
        },
        saveSMSContent(){
            let path = `/${ajax.pathWho}/sms/save_sms_content`;
            let data = this.data.sms_data;

            ajax.sendAjax(data, path)
                .done((response) => {
                    if (response == true) {
                        return location.href = '/office/sms';
                    }
                });
        },
        setBodyField(e){
            let body = $('#smsBody');
            var cursorPos = body.prop('selectionStart');
            var v = body.val();
            var textBefore = v.substring(0, cursorPos);
            var textAfter = v.substring(cursorPos, v.length);

            this.data.sms_data.body = textBefore + e.target.value + textAfter;
        },
        showSMSStatistic(period){
            let path = `/${ajax.pathWho}/sms/show_sms_statistic`;
            let data = {
                period: period,
            };

            ajax.sendAjax(data, path)
                .done((response) => {
                    this.smsStatistic = response;
                    c3.generate({
                        bindto: '#graphics_sms',
                        data: {
                            columns: [
                                this.smsStatistic,
                            ],
                            types: {
                                sms: 'area-spline',
                            }
                        }
                    });
                });
        },
        toggleMenu(hash){
            this.toggleMenuSms = hash;
        }
    }

});

export default SmsinfoVue;
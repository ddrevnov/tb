import Vue from 'vue'
import * as ajax from '../ajax.js'

let DirectorstatsVue = Vue.component('directorstats-vue', {
    template: '#directorstats-templ',

    props: ['data'],

    data(){
        return {
            smsStatistic: [],
            editPackage:{},
        }
    },

    ready() {
        this.showSMSStatistic('week');
    },

    methods: {
        showSMSStatistic(period){
            let path = `/${ajax.pathWho}/sms/show_sms_statistic`;
            let data = {
                period: period,
            };

            ajax.sendAjax(data, path)
                .done((response) => {
                    this.smsStatistic = response;
                    c3.generate({
                        bindto: '#graphics_sms_director',
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
        smsPackageEdit(smsPackage){
            this.$root.openModal('#smsPackageModal');
            this.editPackage = smsPackage;
        }
    }


});

export default DirectorstatsVue;
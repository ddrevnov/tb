import Vue from 'vue';

var vm;

var Tabs = Vue.component('tabs', {
    template: '#tabs-tpl',
    data: function () {
        return {
            times: [],
            services: [],
            selectedServices: [],
            employeesListByService: [],
            employeesList: null,
            activeTab: 0,
            bookingTabs: null,
            bookingAccordion: null,
            nextStepBtn: null,
            calendar: null,
            timepicker: null,

            order: {
                date: null,
                time: '',
                sms: 0,
                email:1,

                employeeId: null,
                employeeName: '',
                employeeAvatar: '',

                serviceId: null,
                serviceTitle: '',
                serviceDescr: '',
                servicePrice: '',
                duration: null,

                guest: {
                    firstName: '',
                    lastName: '',
                    mobile: '',
                    email: ''
                }
            },

            orderIsFormed: false,
            oderIsDirty: false,
            sendingOrder: false,
            orderIsOk: false,

            alertMessages: {
                busyTime: '<div class=\"timepicker-alert\">Dieses Mal ist bereits vergeben. Bitte wählen Sie einen anderen.</div>'
            },

            isEnabledNextBtn: false,

            timepickerAlertElem: null,

            busyTime: false,

            showNextStepBtn: false,

            modalOrderSuccess: null,

            modalLogin: null,

            remodalInst: null,

            remodalInstLogin: null,

            isGuest: false,

            isLogin: false
        }
    },
    ready: function () {
        vm = this;
        vm.setWorkTimes()
            .then(vm.setDom)
            .then(vm.checkAuth);
    },
    watch: {
        'order.timeFrom': function (val, oldVal) {
            if (val !== '' && val !== oldVal) {
                if (vm.orderIsFormed) {
                    vm.showNextStepBtn = true;
                    vm.bookingTabs.tabs('option', 'disabled', [3]);

                }
                vm.checkEmployeeByTime();
            }
        },
        'order.date': function (val, oldVal) {
            if (vm.orderIsFormed && vm.orderIsDirty) {
                vm.showNextStepBtn = true;
                vm.bookingTabs.tabs('option', 'disabled', [3]);
                vm.order.timeFrom = '00:00';
                vm.order.timeTo = '';
            }
        },
        'order.employeeId': function (currentId, prevId) {
            if (currentId !== prevId) {
                if (vm.orderIsFormed) {
                    vm.bookingTabs.tabs('option', 'disabled', [2, 3]);
                    vm.order.timeFrom = '';
                    vm.order.timeTo = '';
                }
            }
        },
        'order.serviceId': function (val, oldVal) {
            if (vm.orderIsFormed) {
                vm.bookingTabs.tabs('option', 'disabled', [1, 2, 3]);
                vm.order.timeFrom = '';
                vm.order.timeTo = '';
            }
        },
        'activeTab': function (currentTab, prevTab) {
            switch (currentTab) {
                case 2:
                    vm.showNextStepBtn = !vm.orderIsFormed;
                    vm.isEnabledNextBtn = false;
                    break;
                case 3:
                    vm.orderIsFormed = true;
                    vm.orderIsDirty = false;
                    vm.showNextStepBtn = false;
                    vm.checkGuest();
                    break;
                default:
                    vm.showNextStepBtn = false;
            }
        }
    },
    methods: {

        setOrderTime(time, e) {
            let $el = $(e.target);
            $('.times__item').removeClass('times__item--active');
            $el.addClass('times__item--active');
            vm.order.timeFrom = time;
            vm.isEnabledNextBtn = true;
        },

        setDom: function () {

            vm.bookingTabs = $('#bookingTabs');
            vm.bookingAccordion = $('#bookingAccordion');
            vm.nextStepBtn = $('#nextStep');
            vm.employeesList = $('.mitarbeiter__item');
            vm.calendar = $('#bookingDatepicker');
            vm.timepicker = $('.booking-tabs__timepicker-input.timepicker-from');
            vm.timepickerContainer = $('.client-booking #bookingTabs-4');
            vm.modalOrderSuccess = $('[data-remodal-id=modal-order-success]');
            vm.modalLogin = $('[data-remodal-id=modal-login]');

            // Widgets activate
            vm.bookingTabs.tabs({
                disabled: [1, 2, 3],
                activate: function (event, ui) {
                    vm.activeTab = vm.bookingTabs.tabs('option').active;
                    let newIndex = ui.newTab.index();
                    let oldIndex = ui.oldTab.index();
                    let arr = $('.booking-tabs__item');

                    if (newIndex > oldIndex) {
                        let diff = newIndex - oldIndex;
                        if (diff > 1) {
                            for (let i = oldIndex; i <= newIndex; i++) {
                                $(arr[i]).addClass('ui-tabs-active');
                            }
                        } else {
                            ui.oldTab.addClass('ui-tabs-active');
                        }
                    } else {
                        for (let i = newIndex + 1; i <= oldIndex; i++) {
                            if (i !== 0) {
                                $(arr[i]).removeClass('ui-tabs-active');
                            }
                        }
                    }
                }
            });
            vm.bookingAccordion.accordion({
                animate: false,
                collapsible: true,
                active: false,
                heightStyle: 'content'
            });
            vm.calendar.datepicker({
                inline: true,
                showOtherMonths: false,
                dateFormat: 'dd/mm/yy',
                minDate: new Date(),
                onSelect: function () {
                    vm.handleDateSelect();
                },
                beforeShowDay: function (date) {
                    var day = vm.getDay(date);
                    var isWorkDay = vm.checkDayByWorkTimes(day);
                    if (!isWorkDay) {
                        return [false, ''];
                    } else {
                        return [true, ''];
                    }
                }
            });
            vm.timepicker.timepicker({
                beforeShow: function () {
                    vm.timepickerContainer.height(200);
                    setTimeout(function () {
                        $('#ui-datepicker-div').css('z-index', 999);
                    }, 0);
                    if (vm.busyTime) {
                        setTimeout(function () {
                            vm.showBusyTimeAlert();
                        }, 0);
                    }
                    vm.setMinMaxTimeByDay();
                },
                onClose: function () {
                    vm.timepickerContainer.height('auto');
                    if (vm.busyTime) {
                        vm.order.timeFrom = '';
                    }
                },
                stepMinute: 15
            });
            vm.remodalInst = vm.modalOrderSuccess.remodal({
                closeOnEscape: false,
                closeOnOutsideClick: false
            });
            vm.remodalInstLogin = vm.modalLogin.remodal({
                closeOnEscape: false,
                closeOnOutsideClick: false
            });

        },
        fetchServices: function (data) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    method: 'POST',
                    url: '/office/get_services',
                    data: data
                })
                .done(function (resp) {
                    vm.services = resp;
                });
        },
        fetchEmployees: function () {
            var data = {'service_id': vm.order.serviceId};
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                    method: 'POST',
                    url: '/get_employees',
                    data: data
                })
                .done(function (resp) {
                    vm.employeesListByService = JSON.parse(resp);
                });
        },
        checkEmployeeByTime: function () {
            console.log('checkEmployeeByTime init');
            var data = {
                'service_id': vm.order.serviceId,
                'date': vm.order.date,
                'id': vm.order.employeeId,
                // 'start_time': vm.order.timeFrom,
                // 'duration': vm.order.duration
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                    method: 'POST',
                    url: '/check_employee',
                    data: data
                })
                .done(function (resp) {
                    if (resp) {
                        vm.times = resp;
                    }
                });
        },
        showSelectedEmployees: function () {
            vm.employeesList.each(function () {
                var employee = $(this);
                employee.hide();
                vm.employeesListByService.forEach(function (elem) {
                    if (employee.data('employee-id') === elem.id) {
                        employee.show();
                    }
                });
            });
        },
        toNextTab: function () {
            vm.activeTab = vm.bookingTabs.tabs('option').active + 1;
            vm.bookingTabs
                .tabs('enable', vm.activeTab)
                .tabs("option", "active", vm.activeTab);
        },
        toBook: function (e) {
            if (!vm.isLogin) {
                e.preventDefault();
                vm.remodalInstLogin.open();
            } else {
                var serviceData = $(e.target).closest('tr').data();

                vm.order.serviceId = serviceData.serviceId;
                vm.order.serviceTitle = serviceData.serviceTitle;
                vm.order.serviceDescr = serviceData.serviceDescr;
                vm.order.duration = serviceData.serviceDur;
                vm.order.servicePrice = serviceData.servicePrice;

                var promise = vm.fetchEmployees();
                promise.then(function () {
                    vm.showSelectedEmployees();
                    vm.toNextTab();
                });
            }
        },
        selectEmployee: function (e) {
            var data = $(e.target).closest('li').data();
            vm.order.employeeId = data.employeeId;
            vm.order.employeeName = data.employeeName;
            vm.order.employeeAvatar = data.employeeAvatar;
            if (vm.orderIsFormed) {
                vm.calendar.datepicker('setDate', null);
            }
            vm.toNextTab();
        },
        handleDateSelect: function () {
            console.log('handleDateSelect');
            var date = vm.calendar.datepicker('getDate');
            var prevDate = vm.order.date;
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + (date.getDate())).slice(-2);

            vm.order.date = day + '/' + month + '/' + date.getFullYear();
            if (vm.orderIsFormed) {
                vm.orderIsDirty = true;
                if (vm.order.date === prevDate) {
                    vm.showNextStepBtn = true;
                    vm.order.timeFrom = '';
                    vm.order.timeTo = '';
                }
            }

            vm.checkEmployeeByTime();
        },
        handleChangeTime: function () {
            console.log(2);
        },
        showBusyTimeAlert: function () {
            $('.ui-timepicker-div + .ui-datepicker-buttonpane').before(vm.alertMessages.busyTime);
            vm.timepickerAlertElem = $('.timepicker-alert');
        },
        getDay: function (date) {
            var day = date.getDay();
            switch (day) {
                case 1:
                    return 0;
                    break;
                case 0:
                    return 6;
                    break;
                default:
                    return day - 1;
            }
        },
        checkDayByWorkTimes: function (day) {
            var result;
            vm.workTimes.forEach(function (elem) {
                if (day === parseInt(elem.index_day) && elem.from !== '00:00:00') {
                    result = true;
                }
            });
            return result === true;
        },
        checkGuest: function () {
            var regForm = $('.booking-ok__reg-form');
            if (regForm.children().length !== 0) {
                vm.isGuest = true;
                $('#guestForm').validate({
                    rules: {
                        email: {
                            email: true
                        }
                    }
                });
            }
        },
        checkAuth: function () {
            var isLogin = $('#loginForm').length;
            vm.isLogin = (isLogin === 0);
        },
        sendOrder: function () {
            var isValidOrder;

            if (vm.isGuest) {
                isValidOrder = $('#guestForm').valid();
            } else {
                isValidOrder = true;
            }


            if (isValidOrder) {
                vm.sendingOrder = true;
                var data = {
                    'service_id': vm.order.serviceId,
                    'employee_id': vm.order.employeeId,
                    'date': vm.order.date,
                    'time_start': vm.order.timeFrom,
                    'sms': vm.order.sms,
                    'email': vm.order.email,
                };
                if (vm.isGuest) {
                    data.first_name = vm.order.guest.firstName;
                    data.last_name = vm.order.guest.lastName;
                    data.mobile_name = vm.order.guest.mobile;
                    data.email = vm.order.guest.email;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        method: 'POST',
                        url: '/new_order',
                        data: data
                    })
                    .done(function (resp) {
                        vm.sendingOrder = false;
                        vm.remodalInst.open();
                    })
                    .fail(function (err) {
                        vm.sendingOrder = false;
                        console.log(err.statusText);
                    });
            }

        },
        closeModal: function () {
            vm.remodalInst.close();
            location.href = '/';
        },
        closeModalLogin: function () {
            vm.remodalInstLogin.close();
        },
        setWorkTimes: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                    method: 'POST',
                    url: '/get_work_times'
                })
                .done(function (resp) {
                    vm.workTimes = JSON.parse(resp);
                });
        },
        setMinMaxTimeByDay: function () {
            var currentDate = vm.calendar.datepicker('getDate');
            var currentDay = vm.getDay(currentDate);
            var timeFrom = vm.workTimes[currentDay].from;
            var timeTo = vm.workTimes[currentDay].to;

            //TODO Add a check on the duration of service

            vm.timepicker.timepicker('option', {
                minTime: timeFrom,
                maxTime: timeTo
            });
        }
    }
});

export default Tabs;

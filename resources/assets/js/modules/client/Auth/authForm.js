import Vue from 'vue';

var vm;

var RestoreForm = Vue.component('authForm', {
    template: '#auth-form-tpl',
    data: function () {
        return {
            showLogin: true,
            showRestore: false,
            restoringPass: false,
            invalidEmailRestore: false,
            validEmailRestore: false,
            restoreEmail: ''
        }
    },
    watch: {
        'restoreEmail': function(val, oldVal) {
            if (this.invalidEmailRestore) {
                this.invalidEmailRestore = false;
            }
        }
    },
    ready: function () {
        vm = this;
    },
    methods: {
        onSubmit: function () {
            var data = {
                'star': parseInt(this.comment.rating),
                'heading': this.comment.title,
                'text': this.comment.text
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                    method: 'POST',
                    url: 'gustebook',
                    data: data
                })
                .done(function (resp) {
                    location.href = "/client/gustebook"
                });
        },
        showRestoreForm: function () {
            this.showRestore = true;
            this.showLogin = false;
        },
        hideRestoreForm: function () {
            if (vm.restoringPass) {
                return false;
            }
            this.restoreEmail = '';
            this.validEmailRestore = false;
            this.invalidEmailRestore = false;
            this.showRestore = false;
            this.showLogin = true;
        },
        restorePassword: function () {
            this.validEmailRestore = false;
            this.restoringPass = true;
            var data = {
                'forgotpass': this.restoreEmail
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                    method: 'POST',
                    url: '/forgotpass',
                    data: data
                })
                .done(function (resp) {
                    var status = !!(parseInt(resp[0]));
                    if (status) {
                        vm.validEmailRestore = true;
                    } else {
                        vm.invalidEmailRestore = true;
                    }
                    vm.restoringPass = false;
                })
                .fail(function(error, text) {
                    console.log(text);
                });
        }
    }
});

export default RestoreForm;

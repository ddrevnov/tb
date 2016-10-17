<template>
    <validator name="validation">
        <form @submit.prevent="signUp" class="login-form" id="clientRegistration" novalidate>
            <fieldset>
                <input class="login-form__input" type="email"
                       v-model="email"
                       v-validate:email="{required: true, email: true}" detect-change="on"
                       :classes="{
                        dirty: 'dirty-reg-email', invalid: 'invalid-reg-email',
                        valid: 'valid-reg-email', pristine: 'pristine-reg-email'}"
                       name="email" placeholder="E-Mail">
                <span class="validation-icon"></span>

                <p class="validation-msg__email-exist" v-if="isEmailExist">Benutzer mit dieser E-Mail ist bereits vorhanden. Bitte geben Sie eine andere
                    E-Mail.</p>
            </fieldset>

            <fieldset>
                <input class="login-form__input" type="text"
                       v-model="phone"
                       name="telephone" placeholder="Telefonnummer">
            </fieldset>

            <fieldset>
                <input class="login-form__input" type="text"
                       v-model="mobile"
                       name="mobile" placeholder="Handy-Nummer">
            </fieldset>

            <fieldset>
                <input class="login-form__input" type="text"
                       v-model="firstName"
                       v-validate:first-name="{required: true}" detect-change="on" detect-blur="off"
                       :classes="{
                       dirty: 'dirty-reg-firstname', invalid: 'invalid-reg-firstname',
                        valid: 'valid-reg-firstname', pristine: 'pristine-reg-firstname'}"
                       name="first_name" placeholder="Vorname">
                <span class="validation-icon"></span>
            </fieldset>

            <fieldset>
                <input class="login-form__input" type="text"
                       v-model="lastName"
                       v-validate:last-name="['required']" detect-change="on" detect-blur="off"
                       :classes="{
                       dirty: 'dirty-reg-lastname', invalid: 'invalid-reg-lastname',
                        valid: 'valid-reg-lastname', pristine: 'pristine-reg-lastname'}"
                       name="last_name" placeholder="Nachname">
                <span class="validation-icon"></span>
            </fieldset>

            <fieldset>
                <input class="login-form__input" id="birthday" type="text"
                       v-model="birthday"
                       name="birthday" placeholder="Geburtstag">
            </fieldset>

            <fieldset>
                <select name="gender" class="login-form__input"
                        v-model="gender">
                    <option value="male">Male</option>
                    <option value="female">Weiblich</option>
                    <option value="" disabled selected class="gender_display">Geschlecht</option>
                </select>
            </fieldset>

            <input class="login-form__submit" type="submit" value="Registrieren" :disabled="sending">
        </form>
    </validator>
</template>
<style>
</style>
<script type="text/babel">
    export default{
        data(){
            return {
                email: null,
                firstName: null,
                lastName: null,
                phone: null,
                mobile: null,
                birthday: null,
                gender: null,

                isEmailExist: false,
                sending: false
            }
        },
        watch: {
            'email': function (val, oldVal) {
                if (this.isEmailExist) {
                    this.isEmailExist = false;
                }
            }
        },
        methods: {
            signUp() {
                this.sending = true;

                this.$validate(true);

                if (this.$validation.invalid) {
                    this.sending = false;
                    return false;
                }

                var vm = this;
                var email = this.email;

                this.checkEmail(email).then(signUpComplete, signUpFailed);

                function signUpComplete(response, textStatus, jqXHR) {
                    var status = JSON.parse(response);
                    if (status) {
                        var data = {
                            'email': vm.email,
                            'first_name': vm.firstName,
                            'last_name': vm.lastName,
                            'telephone': vm.phone,
                            'mobile': vm.mobile,
                            'birthday': vm.birthday,
                            'gender': vm.gender
                        };
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                                    method: 'POST',
                                    url: '/client/store',
                                    data: data
                                })
                                .done(function (resp) {
                                    if (resp.status) {
                                        location.pathname = '/client/settings';
                                    } else {
                                        return false;
                                    }
                                })
                                .fail(function (error, text) {
                                    vm.sending = false;
                                    alert(error);
                                });
                    } else {
                        vm.showEmailError();
                    }
                }

                function signUpFailed(jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                    vm.sending = false;
                }

            },
            checkEmail() {
                var vm = this;
                var data = {
                    'email': this.email
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                return $.ajax({
                    method: 'POST',
                    url: '/check_email',
                    data: data
                })
            },
            showEmailError() {
                this.isEmailExist = true;
                this.sending = false;
                this.$setValidationErrors([
                    {field: 'email'}
                ]);
            }
        }
    }
</script>



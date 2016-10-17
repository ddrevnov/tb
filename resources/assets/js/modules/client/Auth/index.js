import Vue from 'vue';
import authFom from './authForm';



var Auth = Vue.component('auth', {
    components: {
        authFom
    }
});

export default Auth;

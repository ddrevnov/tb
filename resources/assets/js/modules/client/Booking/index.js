import Vue from 'vue';
import tabs from './tabs';

var Booking = Vue.component('booking', {
    components: {
        tabs
    }
});

export default Booking;

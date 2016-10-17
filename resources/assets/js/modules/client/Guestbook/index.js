import Vue from 'vue';
import commentForm from './commentForm';
import comment from './comment';



var Guestbook = Vue.component('guestbook', {
    components: {
        commentForm,
        comment
    }
});

export default Guestbook;

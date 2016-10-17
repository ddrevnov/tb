import Vue from 'vue';

Vue.use(window["VueValidator"]);



var CommentForm = Vue.component('commentForm', {
    template: '#comment-form-tpl',
    data: function() {
        return {
            comment: {
                rating: null,
                title: '',
                text: ''
            }
        }
    },
    methods: {
        onSubmit: function() {

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
                    location.href="/client/gustebook"
                });
        }
    }
});

export default CommentForm;

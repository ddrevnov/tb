import Vue from 'vue';
var vm;

var Comment = Vue.component('comment', {
    props: ['data', 'userId'],
    data: function () {
        return {
            showEditableForm: false,

            savingComment: false,

            deletingComment: false,

            editableComment: {
            },
            comment: {
                id: this.data.id,
                userId: parseInt(this.data.id_clients),
                currentUserId: this.userId,
                name: this.data.first_name,
                title: this.data.heading,
                text: this.data.text,
                time: this.data.created_at,
                stars: parseInt(this.data.star)
            }
        }
    },
    watch: {
        'editableComment.stars': function(val, oldVal) {
            this.editableComment.stars = parseInt(val);
        }
    },
    template: '#comment-tpl',
    ready: function() {
      vm = this;
    },
    methods: {
        showEditForm: function (id, event) {
            this.editableComment = Vue.util.extend({}, this.comment);
            this.showEditableForm = true;
        },
        deleteComment: function(event) {
            this.deletingComment = true;
            var vm = this;

            var data = {
                'id': this.comment.id
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                    method: 'GET',
                    url: '/client/gustebook/comment/delete/' + this.comment.id,
                    data: data
                })
                .done(function (resp) {
                    vm.deletingComment = false;
                    if (resp.status) {
                        vm.$remove();
                    }
                });
        },
        updateComment: function () {
            this.savingComment = true;
            var vm = this;

            var data = {
                'heading': this.editableComment.title,
                'text': this.editableComment.text,
                'stars': this.editableComment.stars
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                    method: 'GET',
                    url: '/client/gustebook/comment/edit/' + this.editableComment.id,
                    data: data
                })
                .done(function (resp) {
                    vm.savingComment = false;
                    if (resp.status) {
                        vm.comment = vm.editableComment;
                        vm.showEditableForm = false;
                    }
                });
        },
        cancelComment: function (id, event) {
            this.showEditableForm = false;
        },
        isMyComment: function() {
            return this.comment.userId === this.comment.currentUserId;
        }
    }
});

export default Comment;

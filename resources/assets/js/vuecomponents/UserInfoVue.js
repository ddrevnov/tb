import Vue from 'vue';
import * as ajax from '../ajax.js';
import croppie from 'croppie';
import Alert from './vue-strap/src/Alert.vue';

var $uploadCrop;

let UserInfoVue = Vue.component('user-info-vue', {
    template: '#user-info-template',

    components: { Alert },

    data() {
        return {
            logoShow: false,
            isSetAvatar: false,
            showAvatarSuccess: false,
            showLogoSuccess: false,
            showImgPreloader: false,
        }
    },
    ready: function () {
    },
    methods: {
        selectFile(e) {
            this.isSetAvatar = true;
            this.readFile(e.target.files);
        },
        readFile(files) {
            if (files && files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    });
                    $('.crops').addClass('ready');
                };
                reader.readAsDataURL(files[0]);
            }
            else {
                alert("Sorry - you're browser doesn't support the FileReader API");
            }

            $uploadCrop = $('.crops').croppie({
                viewport: {
                    width: 290,
                    height: 290,
                    type: 'square'
                },
                boundary: {
                    width: 290,
                    height: 290
                }
            });
        },
        setAvatar(employeeId) {
            let vm = this;
            let url = '';

            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (dataURL) {
                var blob = vm.dataURItoBlob(dataURL);
                var fd = new FormData();
                fd.append("avatar", blob, 'avatar.png');

                if (employeeId) {
                    url = `${ajax.LOCPATH}/store_avatar`;
                } else {
                    url = '/backend/storeavatar';
                }

                vm.showImgPreloader = true;

                $.ajax({
                    url: url,
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (src) {
                        $('.jq-file__name').html('');
                        $('.user-info__avatar').attr('src', src);
                        $('.user-info__avatar-small').attr('src', src);
                        $uploadCrop.croppie('destroy');
                        vm.isSetAvatar = false;
                        vm.logoShow = false;
                        vm.showImgPreloader = false;
                        vm.showAvatarSuccess = true;
                    },
                    error: function() {
                        vm.showImgPreloader = false;
                    }
                });
            });
        },
        dataURItoBlob(dataURI) {
            var byteString;
            if (dataURI.split(',')[0].indexOf('base64') >= 0)
                byteString = atob(dataURI.split(',')[1]);
            else
                byteString = unescape(dataURI.split(',')[1]);

            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

            var ia = new Uint8Array(byteString.length);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }

            return new Blob([ia], {type: mimeString});
        },
        cancelSetAvatar() {
            if ($uploadCrop) {
                $uploadCrop.croppie('destroy');
            }
            $('.jq-file__name').html('');
            this.isSetAvatar = false;
            this.logoShow = false;
        },

        openUserInfoModal() {
            this.$broadcast('openUserInfoModal');
        },

        changeLogo() {
            $('#changeLogo').click();
        },

        changeAvatar() {
            $('#changeAvatar').click();
        },


        sendLogo(e) {
            let vm = this;
            let $form = $(e.target);
            let typeImg = $form.find('input.logo-block__file').attr('name');
            let $input = $form.find('input[type="file"]');
            let fd = new FormData;

            fd.append(typeImg, $input.prop('files')[0]);

            vm.showImgPreloader = true;

            $.ajax({
                url: window.location['pathname'] + '/store_logo',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (src) {
                    vm.showLogoSuccess = true;
                    vm.showImgPreloader = false;
                    $('.jq-file__name').html('');
                    $('.user-info__logo').attr('src', src);
                },
                error: function() {
                    vm.showImgPreloader = false;
                }
            });
        },

        sendAvatar(e) {
            let vm = this;
            let $form = $(e.target);
            var typeImg = $form.find('input.logo-block__file').attr('name');
            var $input = $form.find('input[type="file"]');
            var fd = new FormData;

            fd.append(typeImg, $input.prop('files')[0]);

            vm.showImgPreloader = true;

            $.ajax({
                url: window.location['pathname'] + '/store_avatar',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (src) {
                    vm.showAvatarSuccess = true;
                    vm.showImgPreloader = false;
                    $('.jq-file__name').html('');
                    $('.user-info__avatar').attr('src', src);
                },
                error: function() {
                    vm.showImgPreloader = false;
                }
            });
        }

    }

});

export default UserInfoVue;
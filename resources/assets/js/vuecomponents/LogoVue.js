import Vue from 'vue'
import Alert from './vue-strap/src/Alert.vue'

let LogoVue = Vue.component('logo-vue', {
	template: '#logo-template',

  components: { Alert },

  data() {
    return {
      showLogoSuccess: false,
      showImgPreloader: false
    }
  },

  ready() {
    
  },

  methods: {

    readURL(e) {
      let input = e.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    },

    sendForm() {
      let vm = this;
      var action = $('form.logo-block__form').attr('action');
      var typeImg = $('input.logo-block__file').attr('name');
      var $input = $('input[type="file"]');
      var fd = new FormData;

      fd.append(typeImg, $input.prop('files')[0]);

      vm.showImgPreloader = true;

      $.ajax({
          url: action,
          data: fd,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
              vm.showLogoSuccess = true;
              vm.showImgPreloader = false;

              $('div.logo-block__img img').attr('src', data);
              $('.jq-file__name').html('');
              if(data.indexOf('avatars') + 1){
                  $('.admin-header__avatar').find('img').attr('src', data);
              }
          },
          error: function() {
            vm.showImgPreloader = false;
          }
      });
    },

    sendFormSlider() {
      $('.logo-block__form').submit();
    },

    selectFile() {
      $('.logo-block__file').click();
    }

  }
});

export default LogoVue;
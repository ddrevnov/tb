<template>
  <div class="assistant">

    <section v-show="step === 0" class="assistant-hero">
  <div class="assistant-hero__in">
  <h1 class="assistant-hero__heading">{{ $t("step0.heading") }}, {{ startData.admin_data.firstname }}!</h1>
<p class="assistant-hero__desc">{{ $t("step0.desc") }}</p>
<button
  @click="nextStep"
  class="assistant-btn assistant-btn--red">{{ $t("step0.btn") }}</button>
</div>
</section>

    <section v-show="step === 1" class="assistant-step">
      <h2 class="assistant-heading--h2">{{ $t("all.heading") }}</h2>

    <div class="assistant-step__in">
      <div class="assistant-step__left">

      <div class="assistant-block">
      <div class="assistant-block__label">{{ $t("step1.label1") }}</div>
    <form id="assistantForm1" class="assistant-form">

      <div class="assistant-form__row">
      <div class="assistant-form__col assistant-form__col--3">
      <label for="greeting" class="assistant-form__label">{{ $t("step1.greeting") }}</label>
      <select
        v-model="assistantData.greeting"
        @change="assistantData.gender = assistantData.greeting"
        :value="startData.admin_data.gender"
        name="greeting" id="greeting" class="assistant-input assistant-input--select">
        <option value="male">{{ $t("step1.herr") }}</option>
        <option value="female">{{ $t("step1.frau") }}</option>
      </select>
      </div>
      </div>

      <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--6">
      <label for="first-name" class="assistant-form__label">{{ $t("step1.name") }}</label>
      <input v-model="assistantData.firstname" :value="startData.admin_data.firstname" type="text" name="firstname" class="assistant-input" id="first-name" required>
    </div>

    <div class="assistant-form__col assistant-form__col--6">
      <label for="last-name" class="assistant-form__label">{{ $t("step1.lastName") }}</label>
      <input v-model="assistantData.lastname" :value="startData.admin_data.lastname" type="text" name="lastname" class="assistant-input" id="last-name" required>
    </div>

    </div>

    <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--6">
      <label for="email" class="assistant-form__label">E-Mail</label>
      <input v-model="assistantData.email" :value="startData.admin_data.email" type="email" class="assistant-input" id="email" required name="email">
    </div>

    <div class="assistant-form__col assistant-form__col--6">
      <label for="website" class="assistant-form__label">Website</label>
      <input v-model="assistantData.firmname" type="text" class="assistant-input" id="website" required name="firmname">
      </div>

      </div>

      <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--6">
      <label for="phone" class="assistant-form__label">{{ $t("step1.tel") }}</label>
      <input v-model="assistantData.telnumber" :value="startData.admin_data.telnumber" type="tel" class="assistant-input" id="phone" required name="telnumber">
    </div>

    <div class="assistant-form__col assistant-form__col--6">
      <label for="mobile" class="assistant-form__label">{{ $t("step1.mobile") }}</label>
      <input v-model="assistantData.mobile" :value="startData.admin_data.mobile" type="tel" class="assistant-input" id="mobile" name="mobile">
      </div>

      </div>

      <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--6">
      <label for="gender" class="assistant-form__label">{{ $t("step1.gender") }}</label>
      <select
        v-model="assistantData.gender"
        @change="assistantData.greeting = assistantData.gender"
        :value="startData.admin_data.gender"
        name="gender" id="gender" class="assistant-input assistant-input--select">
      <option value="male">{{ $t("step1.male") }}</option>
      <option value="female">{{ $t("step1.female") }}</option>
      </select>
      </div>
        
        <div class="assistant-form__col assistant-form__col--6">
          <label for="birthday" class="assistant-form__label">{{ $t("step1.birthday") }}</label>
          <input
            v-model="assistantData.birthday"
            name="birthday"
            id="birthday" class="assistant-input input-date" type="text">
        </div>

      </div>

      </form>
      </div>

      <div class="assistant-step__btns">
      <button
        @click="prevStep"
        class="assistant-btn assistant-btn--gray">{{ $t("all.back") }}</button>
      <button
        @click="nextStep"
        class="assistant-btn assistant-btn--red">{{ $t("all.next") }}</button>
      </div>
      </div>

    <form
      class="assistant-block assistant-upload" id="assistantUploadAvatar">
      <div class="assistant-block__label">{{ $t("step1.label2") }}</div>
      <div @dragover.prevent @drop="onFileChange($event, 'avatar')" class="assistant-upload__drop">
        <input class="assistant-block__file" id="assistantAvatar" type="file" @change="onFileChange($event, 'avatar')">
        <img class="assistant-upload__image" :src="imgs.avatar" />
      </div>

      <button @click.stop.prevent="changeAvatar" class="assistant-upload__btn assistant-btn assistant-btn--red">{{ $t("step1.uploadAvatar") }}</button>
    </form>

    </div>
    </section>

    <section v-show="step === 2" class="assistant-step">
      <h2 class="assistant-heading--h2">{{ $t("all.heading") }}</h2>

    <div class="assistant-step__in">
      <div class="assistant-step__left">

      <div class="assistant-block">
      <div class="assistant-block__label">{{ $t("step2.label1") }}</div>
    <form id="assistantForm2" class="assistant-form">

      <div class="assistant-form__row">
      <div class="assistant-form__col assistant-form__col--12">
      <label for="name-company" class="assistant-form__label">{{ $t("step2.companyName") }}</label>
      <input v-model="assistantData.firm_name" type="text" name="firm_name" class="assistant-input" id="name-company">
    </div>
    </div>

    <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--4">
      <label for="country" class="assistant-form__label">{{ $t("all.country") }}</label>
      <select
        v-model="assistantData.country"
        @change.stop="getStates(assistantData.country)"
        name="country" id="country" class="assistant-input assistant-input--select" placeholder="Select country...">
        <option v-for="country in countries" :value="country.country_id">{{ country.name }}</option>
    </select>
    </div>

      <div class="assistant-form__col assistant-form__col--4">
        <label for="state" class="assistant-form__label">{{ $t("all.region") }}</label>
        <select
          @change.stop="getCities(assistantData.state)"
          v-model="assistantData.state" name="state" id="state" class="assistant-input assistant-input--select" placeholder="Select state...">
          <option v-for="state in states" :value="state.state_id">{{ state.name }}</option>
        </select>
      </div>

    <div class="assistant-form__col assistant-form__col--4">
      <label for="city" class="assistant-form__label">Stadt</label>
      <select v-model="assistantData.city" class="assistant-input assistant-input--select" name="city" id="city" placeholder="Select city...">
        <option v-for="city in cities" :value="city.city_id">{{ city.name }}</option>
    </select>
    </div>

    </div>

    <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--6">
      <label for="index" class="assistant-form__label">{{ $t("all.postIndex") }}</label>
      <input v-model="assistantData.post_index" type="text" class="assistant-input" id="index" name="post_index" required>
    </div>

    <div class="assistant-form__col assistant-form__col--6">
      <label for="street" class="assistant-form__label">{{ $t("all.address") }}</label>
      <input v-model="assistantData.street" type="text" class="assistant-input" id="street" name="street" required>
    </div>

    </div>

    <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--6">
      <label for="business" class="assistant-form__label">{{ $t("all.business") }}</label>
      <select v-model="assistantData.firmtype" name="firmtype" id="business" class="assistant-input assistant-input--select" placeholder="Wähle Deine Branche aus…">
        <option value="">{{ $t("step2.business") }}</option>
        <option
          v-for="firmtype in startData.firmtype"
          :selected="firmtype.id === startData.admin_data.firmtype"
          :value="firmtype.id">{{ firmtype.firmtype }}</option>
    </select>
    </div>

    </div>

    </form>
    </div>

    <div class="assistant-step__btns">
      <button
        @click="prevStep"
        class="assistant-btn assistant-btn--gray">{{ $t("all.back") }}</button>
      <button
        @click="nextStep"
        class="assistant-btn assistant-btn--red">{{ $t("all.next") }}</button>
      </div>
      </div>

      <div class="assistant-block assistant-upload" id="assistantUploadLogo">
        <div class="assistant-block__label">{{ $t("step2.label2") }}</div>
        <div @dragover.prevent @drop="onFileChange($event, 'logo')" class="assistant-upload__drop">
          <input class="assistant-block__file" id="assistantLogo" type="file" @change="onFileChange($event, 'logo')">
          <img class="assistant-upload__image" :src="imgs.logo" />
        </div>

        <button @click.stop.prevent="changeLogo" class="assistant-upload__btn assistant-btn assistant-btn--red">{{ $t("step2.uploadLogo") }}</button>
      </div>

    </div>
    </section>

    <!--<section v-show="step === 3" class="assistant-step">-->
      <!--<h2 class="assistant-heading&#45;&#45;h2">{{ $t("step3.heading") }}</h2>-->

      <!--<div class="assistant-step__in">-->

        <!--<div v-for="tariff in startData.tariff" class="assistant-tariff">-->
            <!--<div class="assistant-tariff__heading">{{ tariff.name }}-->
            <!--<div class="assistant-tariff__desc">{{ tariff.description }}</div>-->
          <!--</div>-->

          <!--<div class="assistant-tariff__main">-->
            <!--<div class="assistant-tariff__price">{{ tariff.price }}<span class="assistant-tariff__currency">€</span></div>-->
            <!--<div class="assistant-tariff__time">-->
              <!--{{ tariff.type === 'paid' ? $t("step3.monthly") : tariff.duration + ' ' + $t("step3.freeDays") | uppercase }}-->
            <!--</div>-->
              <!--<ul class="assistant-tariff__list">-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ $t("step3.customerDb") }}-->
                <!--</li>-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ $t("step3.onlineCal") }}-->
                <!--</li>-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ $t("step3.onlineBook") }}-->
                <!--</li>-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ $t("step3.customerFeedback") }}-->
                <!--</li>-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ $t("all.statistic") | capitalize }} / {{ $t("all.reports") | capitalize }} ({{ +tariff.dashboard_unlimited === 0 ? tariff.dashboard_count : $t("all.unlimited") }} {{ $t("all.days") }})-->
                <!--</li>-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ $t("step3.newsletterMarketing") }}  ({{ +tariff.letters_unlimited === 0 ? tariff.letters_count : $t("all.unlimited") }} {{ $t("all.recipient") }})-->
                <!--</li>-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ +tariff.employee_unlimited === 0 ? tariff.employee_count : $t("all.unlimited") }} {{ $t("all.employee") }}-->
                <!--</li>-->
                <!--<li class="assistant-tariff__item">-->
                  <!--<i></i>-->
                  <!--{{ $t("step3.eventReminder") }}-->
                <!--</li>-->

                <!--&lt;!&ndash;<li class="assistant-tariff__item">&ndash;&gt;-->
                <!--&lt;!&ndash;<i></i>&ndash;&gt;-->
                  <!--&lt;!&ndash;{{ $t("step3.reports") }}&ndash;&gt;-->
              <!--&lt;!&ndash;</li>&ndash;&gt;-->
                <!--&lt;!&ndash;<li class="assistant-tariff__item">&ndash;&gt;-->
                <!--&lt;!&ndash;<i></i>&ndash;&gt;-->
                <!--&lt;!&ndash;{{ $t("step3.management") }}&ndash;&gt;-->
                <!--&lt;!&ndash;</li>&ndash;&gt;-->
                <!--&lt;!&ndash;<li class="assistant-tariff__item">&ndash;&gt;-->
                  <!--&lt;!&ndash;<i></i>&ndash;&gt;-->
                  <!--&lt;!&ndash;{{ +tariff.services_unlimited === 0 ? tariff.services_count : $t("all.unlimited") }} Services&ndash;&gt;-->
                <!--&lt;!&ndash;</li>&ndash;&gt;-->



            <!--</ul>-->
          <!--</div>-->
          <!--<button-->
            <!--@click="getTariffName($event)"-->
            <!--data-tariff-name="{{ tariff.id }}"-->
            <!--class="assistant-tariff__btn assistant-btn">{{ $t("step3.order") }}</button>-->
        <!--</div>-->

      <!--</div>-->

      <!--<div class="assistant-tariff__bottom">-->
        <!--<button-->
          <!--@click="prevStep"-->
          <!--class="assistant-btn assistant-btn&#45;&#45;gray">{{ $t("all.back") }}</button>-->
      <!--</div>-->
  <!--</section>-->

    <section v-show="step === 3" class="assistant-step">
  <h2 class="assistant-heading--h2">{{ $t("all.heading") }}</h2>

<div class="assistant-step__in">
  <div class="assistant-step__left">

  <div class="assistant-block">
  <div class="assistant-block__label">{{ $t("all.billingAddress") }}</div>
  <form id="assistantForm4" class="assistant-form">

    <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--12">
        <label for="companyName2" class="assistant-form__label">{{ $t("step4.companyName") }}</label>
        <input v-model="assistantData.legal_firm_name" type="text" class="assistant-input" id="companyName2" name="legal_firm_name">
      </div>

    </div>

    <div class="assistant-form__row">

      <div class="assistant-form__col assistant-form__col--4">
        <label for="country2" class="assistant-form__label">{{ $t("all.country") }}</label>
        <select
          v-model="assistantData.legal_country"
          @change.stop="getStates(assistantData.legal_country)"
          name="country" id="country2" class="assistant-input assistant-input--select" placeholder="Select country...">
          <option v-for="country in countries" :value="country.country_id">{{ country.name }}</option>
        </select>
      </div>

      <div class="assistant-form__col assistant-form__col--4">
        <label for="state2" class="assistant-form__label">{{ $t("all.region") }}</label>
        <select
          @change.stop="getCities(assistantData.legal_state)"
          v-model="assistantData.legal_state" name="state" id="state2" class="assistant-input assistant-input--select" placeholder="Select state...">
          <option v-for="state in states" :value="state.state_id">{{ state.name }}</option>
        </select>
      </div>

      <div class="assistant-form__col assistant-form__col--4">
        <label for="city2" class="assistant-form__label">{{ $t("all.city") }}</label>
        <select v-model="assistantData.legal_city" class="assistant-input assistant-input--select" name="city" id="city2" placeholder="Select city...">
          <option v-for="city in cities" :value="city.city_id">{{ city.name }}</option>
        </select>
      </div>

    </div>

<div class="assistant-form__row">

  <div class="assistant-form__col assistant-form__col--3">
  <label for="index2" class="assistant-form__label">{{ $t("all.postIndex") }}</label>
  <input v-model="assistantData.legal_post_index" type="text" class="assistant-input" id="index2" name="post_index">
</div>

<div class="assistant-form__col assistant-form__col--9">
  <label for="street2" class="assistant-form__label">{{ $t("all.address") }}</label>
  <input v-model="assistantData.legal_street" type="text" class="assistant-input" id="street2" name="street">
</div>

</div>

</form>
</div>

<div class="assistant-block">
  <div class="assistant-block__label">{{ $t("all.bankDetails") }}</div>
  <form id="assistantForm4-2" class="assistant-form">
    
    <div class="assistant-form__row">
      <div class="assistant-form__col--12">
        <label>
          <input
            @change.stop="assistantData.agreement = 0"
            v-model="bankInfo" value="no" type="radio"> {{ $t("step4.radioNo") }}
        </label>
        <label>
          <input
          @change.stop="assistantData.agreement = 1"
          v-model="bankInfo" value="yes" type="radio"> {{ $t("step4.radioYes") }}
        </label>
      </div>
    </div>

  <div v-show="assistantData.agreement === 1" class="assistant-form__row">

  <div class="assistant-form__col assistant-form__col--6">
  <label for="iban" class="assistant-form__label">IBAN</label>
  <input
    v-model="assistantData.iban"
    :disabled="bankInfo === 'no'"
    type="text" class="assistant-input" id="iban" name="iban">
</div>

<div class="assistant-form__col assistant-form__col--6">
  <label for="bic" class="assistant-form__label">BIC</label>
  <input
    v-model="assistantData.bic"
    :disabled="bankInfo === 'no'"
    type="text" class="assistant-input" id="bic" name="bic">
</div>

</div>

<div v-show="assistantData.agreement === 1" class="assistant-form__row">

  <div class="assistant-form__col assistant-form__col--6">
  <label for="bank" class="assistant-form__label">{{ $t("all.bankName") }}</label>
  <input
    v-model="assistantData.bank_name"
    :disabled="bankInfo === 'no'"
    type="text" class="assistant-input" id="bank" name="bank_name">
</div>

<div class="assistant-form__col assistant-form__col--6">
  <label for="owner" class="assistant-form__label">{{ $t("all.owner") }}</label>
  <input
    v-model="assistantData.account_owner"
    :disabled="bankInfo === 'no'"
    type="text" class="assistant-input" id="owner" name="account_owner">
</div>

</div>

<div
  v-show="bankInfo === 'yes'"
  class="assistant-form__row">
  <div>
  <input
    @change.stop="assistantData.agreement ? assistantData.agreement = 1 : assistantData.agreement = 0"
    v-model="assistantData.agreement"
    :disabled="bankInfo === 'no'"
    id="assistantAgreeCheckbox"
    class="assistant-form__checkbox assistant-input--checkbox"
    name="agreement" type="checkbox">
  <label class="" for="assistantAgreeCheckbox"></label>
  </div>
  <div>{{ $t("step4.agreeMess") }}</div>
</div>

</form>
</div>

<div class="assistant-step__btns">
  <button
    @click="prevStep"
    class="assistant-btn assistant-btn--gray">{{ $t("all.back") }}</button>
  <button
    @click="nextStep"
    class="assistant-btn assistant-btn--red">{{ $t("all.next") }}</button>
  </div>
  </div>

  </div>
  </section>

    <section v-show="step === 4" class="assistant-hero">
  <div class="assistant-hero__in">
  <div>
    <div class="assistant-hero__ok"></div>
    <h1 class="assistant-hero__heading">{{ $t("step5.heading") }}</h1>
    <p class="assistant-hero__desc">{{ $t("step5.desc") }}</p>
    <a href="/office" class="assistant-btn assistant-btn--red">{{ $t("all.next") }}</a>
</div>
  </div>
  </section>

  </div>
  </template>
<script>
  import Vue from 'vue'
  import * as ajax from '../ajax.js'
  import { GET_COUNTRIES, GET_STATES, GET_CITIES } from '../mixins.js'

  export default {

    data() {
      return {
        step: 0,
        bankInfo: 'no',
        imgs: {
          avatar: '',
          logo: ''
        },
        assistantData: {
          agreement: 0
        },
        countries: [],
        states: [],
        cities: [],
        startData: {
          admin_data: {}
        }
      }
    },

    mixins: [GET_COUNTRIES, GET_STATES, GET_CITIES],

    ready() {
      this.getCountries();
      this.getStartData();
    },

    methods: {

      dataURItoBlob(dataURI) {
        var binary = atob(dataURI.split(',')[1]);
        var array = [];
        for(var i = 0; i < binary.length; i++) {
          array.push(binary.charCodeAt(i));
        }
        return new Blob([new Uint8Array(array)], {type: 'image/jpeg'});
      },

      changeAvatar() {
        $('#assistantAvatar').click();
      },

      changeLogo() {
        $('#assistantLogo').click();
      },

      onFileChange(e, who) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createImage(files[0], who);
      },

      createImage(file, who) {
        var image = new Image();
        var reader = new FileReader();
        var vm = this;

        reader.onload = (e) => {
          vm.imgs[who] = e.target.result;

          if (who === 'avatar') {
            this.sendAvatar('#assistantUploadAvatar');
          } else if (who === 'logo') {
            this.sendLogo('#assistantUploadLogo');
          }
        };
        reader.readAsDataURL(file);

      },

      getCountries() {
        let path = `/${ajax.pathWho}/get_location`;

        ajax.sendAjax({}, path)
          .done((countries) => {
          this.countries = countries;
        });
      },

      getStartData() {
        let data = {};
        let path = `/${ajax.pathWho}/start_assistant/get_start_data`;

        ajax.sendAjax(data, path)
          .done((startData) => {
            this.startData = startData;
          });
      },

      sendAvatar() {
        let vm = this;
        let $form = $('#assistantUploadAvatar');
        let $input = $form.find('input[type="file"]');
        let fd = new FormData;

        fd.append('avatar', $input.prop('files')[0]);

        vm.showImgPreloader = true;

        $.ajax({
          url: window.location['pathname'] + '/store_avatar',
          data: fd,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (src) {
            vm.showImgPreloader = false;
          },
          error: function() {
            vm.showImgPreloader = false;
          }
        });
      },

      sendLogo(form) {
        let vm = this;
        let $form = $('#assistantUploadLogo');
        let $input = $form.find('input[type="file"]');
        let fd = new FormData;

        fd.append('firm_logo', $input.prop('files')[0]);

        vm.showImgPreloader = true;

        $.ajax({
          url: window.location['pathname'] + '/store_logo',
          data: fd,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (src) {
            vm.showImgPreloader = false;
          },
          error: function() {
            vm.showImgPreloader = false;
          }
        });
      },

      nextStep() {
        let vm = this;
        let isValidStep = this.isValidStep(this.step);

        if (isValidStep) {

          if (this.step === 3) {
            let data = this.assistantData;
            let path = `/${ajax.pathWho}/start_assistant/confirm`;

            $.ajax({
              type     : 'POST',
              url      : path,
              dataType : 'JSON',
              data     : data
            })
            .done((res) => {
              if (res) {
                this.step = this.step + 1;
              }
            })
            .fail(() => {
              return;
            });

          }

          if (this.step < 3) {
            this.step = this.step + 1;
          }

        }

      },

      bankInputHandler() {
        let isEmpty = !!!(this.assistantData.iban ||
                      this.assistantData.bic ||
                      this.assistantData.bank_name ||
                      this.assistantData.account_owner);
        console.log(isEmpty);

        if (isEmpty) {
          this.assistantData.agreement = 0;
        } else {
          this.assistantData.agreement = 1;
        }
      },

      prevStep() {
        this.step = this.step - 1;
      },

      getTariffName(e) {
        let $btn = $(e.target);
        this.assistantData.tariff_id = $btn.attr('data-tariff-name');

        this.nextStep();
      },

      isValidStep(step) {
        switch (step) {
          case 0: return true; break;

          case 1:
            let form = $('#assistantForm1');
            let isValid = form.valid();

//            if (this.imgs.avatar === '') {
//              $('#assistantUploadAvatar').addClass('animated bounce');
//              setTimeout(() => $('#assistantUploadAvatar').removeClass('animated bounce'), 1000);
//            }

            if (isValid) {
              return true;
            } else {
              return false;
            }

            break;

          case 2:
            form = $('#assistantForm2');
            isValid = form.valid();

//            if (this.imgs.logo === '') {
//              $('#assistantUploadLogo').addClass('animated bounce');
//              setTimeout(() => $('#assistantUploadLogo').removeClass('animated bounce'), 1000);
//            }

            if (isValid) {
              return true;
            } else {
              return false;
            }

            break;

//          case 3:
//            isValid = !!(this.assistantData.tariff_id);
//            return isValid;
//            break;

          case 3:
            form = $('#assistantForm4');
            let form2 = $('#assistantForm4-2');

            isValid = form.valid();

            let isAgree = this.assistantData.agreement;

              if(isValid && isAgree) {
                let isValid2 = form2.valid();

                if (isValid2) {
                  return true;
                } else {
                  return false;
                }

              } else if (isValid && !isAgree) {
                return true;
              } else if ( isValid && !isAgree &&
                !(this.assistantData.iban ||
                  this.assistantData.bic ||
                  this.assistantData.bank_name ||
                  this.assistantData.account_owner) ) {
                return true;
              } else {
                return false;
              }

            break;

          case 4: return false; break;
        }
      }
    },
  }
</script>

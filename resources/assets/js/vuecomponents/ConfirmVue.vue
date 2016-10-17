<template>
    <div
      v-show="show"
      class="confirm-vue">
        <div :class="['confirm-vue__in', {'animated bounce': show}]">
            <div class="confirm-vue__text">
                <slot></slot>
            </div>
            <div>
                <button class="confirm-vue__btn confirm-vue__btn--cancel" @click="cancel">Cancel</button>
                <button class="confirm-vue__btn confirm-vue__btn--ok" @click="ok">OK</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
            }
        },

        ready() {
        },

        props: {
            show: {
                type: Boolean,
                default: false,
                twoWay: true
            },

            isConfirm: {
                type: Boolean,
                default: false,
                twoWay: true
            }
        },

        methods: {

            cancel() {
                this.isConfirm = false;
                this.show = false;
                this.$dispatch('changeTariff');
          },

            ok() {
                this.isConfirm = true;
                this.show = false;
                this.$dispatch('changeTariff');
          },
        },

    }
</script>

<style lang="scss" scoped>
    .confirm-vue {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        margin: auto;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 1000;

        &__in {
             width: 480px;
             height: 100px;
             background-color: #fff;
             position: absolute;
             top: 0;
             bottom: 0;
             right: 0;
             left: 0;
             text-align: center;
             margin: auto;
             border-radius: 10px;
         }

         &__text {
             font-size: 16px;
         }
         
         &__btn {
              border: 0;
              display: inline-block;
              padding: 12px 20px;
              border-radius: 20px;
              color: #ffffff;
              text-align: center;
            
              &--ok {
                   background-color: #5dca73;
                   &:hover {
                      background-color: darken(#5dca73, 20%);
                   }
              }

              &--cancel {
                   background-color: #adb7be;
                   &:hover {
                      background-color: darken(#adb7be, 20%);
                   }
              }
          }
    }
</style>
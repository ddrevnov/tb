<template>
  <div
    v-show="show"
    v-bind:class="{
      'alert':		true,
      'alert-success':(type == 'success'),
      'alert-warning':(type == 'warning'),
      'alert-info':	(type == 'info'),
      'alert-danger':	(type == 'danger'),
      'top': 			(placement === 'top'),
      'top-right': 	(placement === 'top-right')
    }"
    transition="fade"
    v-bind:style="{width:width}"
    role="alert">
    <button v-show="dismissable" type="button" class="close"
      @click="show = false">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" enable-background="new 0 0 44 44"><path d="M22 0c-12.2 0-22 9.8-22 22s9.8 22 22 22 22-9.8 22-22-9.8-22-22-22zm3.2 22.4l7.5 7.5c.2.2.3.5.3.7s-.1.5-.3.7l-1.4 1.4c-.2.2-.5.3-.7.3-.3 0-.5-.1-.7-.3l-7.5-7.5c-.2-.2-.5-.2-.7 0l-7.5 7.5c-.2.2-.5.3-.7.3-.3 0-.5-.1-.7-.3l-1.4-1.4c-.2-.2-.3-.5-.3-.7s.1-.5.3-.7l7.5-7.5c.2-.2.2-.5 0-.7l-7.5-7.5c-.2-.2-.3-.5-.3-.7s.1-.5.3-.7l1.4-1.4c.2-.2.5-.3.7-.3s.5.1.7.3l7.5 7.5c.2.2.5.2.7 0l7.5-7.5c.2-.2.5-.3.7-.3.3 0 .5.1.7.3l1.4 1.4c.2.2.3.5.3.7s-.1.5-.3.7l-7.5 7.5c-.2.1-.2.5 0 .7z"/></svg>
    </button>
    <slot></slot>
  </div>
</template>

<script>
import coerceBoolean from './utils/coerceBoolean.js'

  export default {
    props: {
      type: {
        type: String
      },
      dismissable: {
        type: Boolean,
        coerce: coerceBoolean,
        default: false,
      },
      show: {
        type: Boolean,
        coerce: coerceBoolean,
        default: true,
        twoWay: true
      },
      duration: {
        type: Number,
        default: 0
      },
      width: {
        type: String
      },
      placement: {
        type: String
      }
    },
    watch: {
      show(val) {
        if (this._timeout) clearTimeout(this._timeout)
        if (val && Boolean(this.duration)) {
          this._timeout = setTimeout(()=> this.show = false, this.duration)
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
.fade-transition {
  transition: opacity .3s ease;
}
.fade-enter,
.fade-leave {
  height: 0;
  opacity: 0;
}
.alert {
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  border-radius: 4px;
}
.alert.top {
  position: fixed;
  top: 30px;
  margin: 0 auto;
  left: 0;
  right: 0;
  z-index: 2;
}
.alert.top-right {
  position: fixed;
  top: 30px;
  right: 50px;
  z-index: 2;
}
.alert-success {
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;

  .close svg {
    fill: #3c763d;
  }
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;

    .close svg {
      fill: #a94442;
    }
}
.close {
  border: 0;
  background-color: transparent;
  position: absolute;
  top: 10px;
  right: 10px;

  svg {
    width: 16px;
    height: 16px;
  }
}
</style>

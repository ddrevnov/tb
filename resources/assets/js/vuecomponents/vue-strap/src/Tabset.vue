<template>
  <div class="{{ position === 'left' ? 'tabs-left' : '' }}">
    <!-- Nav tabs -->
     <ul class="nav nav-{{navStyle}}" role="tablist">
            <li
                v-for="r in renderData"
                v-bind:class="{
                  'active': ($index === active),
                  'disabled': r.disabled
                }"
                @click.prevent="handleTabListClick($index, r)"
                :disabled="r.disabled"
            >
                <a href="#">  
                    <slot name="header"> 
                      {{{r.header}}} <span>{{{r.count}}}</span>
                  </slot> 
                </a>
            </li>
     </ul>

     <!-- Tab panes -->
     <div class="tab-content" v-el:tab-content>
        <slot></slot>
     </div>
  </div>
</template>

<script>
  export default {
    props: {
      navStyle: {
        type: String,
        default: 'tabs'
      },
      position: {
        type: String,
        default: 'left'
      },
      effect: {
        type: String,
        default: 'fadein'
      },
      active: {
        type: Number,
        default: 0
      },
    },
    data() {
      return {
        renderData: [],
      }
    },
    methods: {
        handleTabListClick(index, el) {
            if (!el.disabled) this.active = index
        }
    }
  }
</script>

<style lang="scss" scoped>

  .tabs-left {
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: -o-flex;
    display: flex;
    justify-content: space-between;
    border: 1px solid rgba(0,0,0,.15);
    width: 350px;

    .tab-content {
        background-color: #fff;
        padding: 10px;
        width: 70%;
      }

    .nav-tabs {
      padding: 0;
      margin: 0;
      width: 30%;
      li {
        display: block;
        background-color: #f8fafb;
        a {
          display: block;
          padding: 10px;
          text-decoration: none;
          color: #5c6470;
          font-weight: 700;
        }
        &.active {
          background-color: #fff;
        }
      }
    }
  }
</style>

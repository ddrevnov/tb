<template>
    <ul v-show="countPages > 1" class="pagination">
        <!--<li @click="getNumberPage(count&#45;&#45;)" class="disabled"><span>«</span></li>-->
        <li
          v-for="item in countPages"
          @click.stop="getNumberPage($index+1, $event)"
          :class="{ 'active': $index == 0 }">
            {{ $index+1 }}
        </li>
        <!--<li @click="getNumberPage(count++)"><span>»</span></li>-->
    </ul>
</template>

<script>
    export default {
        data(){
            return {
            }
        },

        props: {
           count: Number,
        },

    computed: {
        countPages: function() {
            return Math.ceil(this.count/15);
        }
    },

        methods: {
            getNumberPage(index, e) {
                let $el = $(e.target);

                this.$dispatch('getOrders', index);

                $el.closest('.pagination').find('li').removeClass('active');
                $el.addClass('active');
            }
        }
    }
</script>

<style>

</style>
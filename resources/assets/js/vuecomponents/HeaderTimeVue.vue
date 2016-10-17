<template>
    <span class="admin-header__time">{{ clock.hours }}:{{ clock.mins }}</span>
</template>

<script>
    export default{
        data(){
            return{
                clock: {
                    hours: '',
                    mins: ''
                }
            }
        },
        ready() {
           this.clockInit();
        },
        methods: {
            clockInit() {

                setInterval(() => {
                    let hours = new Date().getHours();
                    let mins = new Date().getMinutes();

                    hours = ("0" + hours).slice(-2);

                    if (mins < 10) {
                        mins = '0' + mins;
                    }

                    this.clock.hours = hours;
                    this.clock.mins = mins;

                }, 1000 );
            },
        }
    }
</script>
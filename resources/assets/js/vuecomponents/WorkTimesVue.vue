<template>
  <table class="table table--striped">

    <thead>
      <tr>
        <th>Tage</th>
        <th>Startzeit</th>
        <th>Endzeit</th>
        <th>Geschlossen</th>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="worktime in worktimes"
        class="worktime-tr">
        <td><span>{{ days[$index] }}</span></td>
        <td>
          <span v-show="!isEdit">{{ worktime.close ? 'Close' : worktime.from }}</span>
          <input
            v-model="worktime.from"
            v-show="isEdit" type="text" class="worktime-timepicker">
        </td>
        <td>
          <span v-show="!isEdit">{{ worktime.close ? '' : worktime.to }}</span>
          <input
            v-model="worktime.to"
            v-show="isEdit" type="text" class="worktime-timepicker">
        </td>
        <td>
          <input v-show="!isEdit && worktime.close" type="checkbox" checked disabled>
          <input
            v-show="isEdit"
            :checked="worktime.close"
            @change.stop="closeShop($event, $index)" type="checkbox">
        </td>
      </tr>
    </tbody>

  </table>

  <div class="admin-edit-button">
    <a
      @click.stop="editWorktimes"
      href="javascript:void(0);"
      class="btn btn--red">Jetzt ändern</a>
  </div>
</template>

<script>
  import Vue from 'vue';
  import * as ajax from '../ajax.js';
  import filters from '../filters.js';

  export default {
    data() {
      return {
        worktimes: ['first'],
        isEdit: false,
        days: [
          'Montag',
          'Dienstag',
          'Mittwoch',
          'Donnerstag',
          'Freitag',
          'Samstag',
          'Sonntag'
        ]
      }
    },

  filters: filters,

    ready() {

    },


  methods: {

    editWorktimes() {

      if (this.isEdit) {
        let data = {
          worktimes: this.worktimes
        };
        let path = `${ajax.LOCPATH}/edit_worktimes`;

        ajax.sendAjax(data, path)
          .done((res) => {
          if (res) {
            this.worktimes = ['first'];
            this.$emit('getWorktimes');
          }
        });
      }
      this.isEdit = !this.isEdit;
    },

    closeShop(e, i) {
      let $checkbox = $(e.target);

      if ($checkbox.is(':checked')) {
        this.worktimes[i].close = true;
        this.worktimes[i].from = '00:00:00';
        this.worktimes[i].to = '00:00:00';
      } else {
        this.worktimes[i].close = false;
      }

    },

    timepickerInit() {
      console.log('asdf');

      setTimeout(() => {
        $('.worktime-timepicker').timepicker({
          stepMinute: 15,
          defaultValue: '8:00',
          timeFormat: 'H:mm',
        });
      }, 2000);

    },

  },

  events: {
    getWorktimes() {
      let data = {};
      let path = `${ajax.LOCPATH}/get_worktimes`;

      if (this.worktimes[0] === 'first') {
        ajax.sendAjax(data, path)
          .done((worktimes) => {

          if (worktimes.length === 0) {
            this.worktimes = [
              {close: true, from: '00:00:00', to: '00:00:00'},
              {close: true, from: '00:00:00', to: '00:00:00'},
              {close: true, from: '00:00:00', to: '00:00:00'},
              {close: true, from: '00:00:00', to: '00:00:00'},
              {close: true, from: '00:00:00', to: '00:00:00'},
              {close: true, from: '00:00:00', to: '00:00:00'},
              {close: true, from: '00:00:00', to: '00:00:00'}
            ];
            this.timepickerInit();
            return;
          }

          this.worktimes = worktimes;
          this.timepickerInit();
        });
      };

    },
  }

  }
</script>

<style>

</style>


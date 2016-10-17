import moment from 'moment'

let domen = 'https://' + /:\/\/([^\/]+)/.exec(window.location.href)[1];
export const SOCKET = io.connect(domen + ':8303', {secure: true});
export const MYID = +$('[type="hidden"][name="my_id"]').val();

export function validateEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

export function validateTime(start, end){
   start = start.split(/:/);
   end = end.split(/:/);
   return (+start[0] < +end[0]) || (+start[0] == +end[0] && +start[1] < +end[1]);
}

export function getMonthDateRange(year, month) {

    // month in moment is 0 based, so 9 is actually october, subtract 1 to compensate
    // array is 'year', 'month', 'day', etc
    var startDate = moment([year, month - 1]);

    // Clone the value before .endOf()
    var endDate = moment(startDate).endOf('month');

    // make sure to call toDate() for plain JavaScript date type
    return { start: startDate, end: endDate };
}
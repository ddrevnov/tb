export const LOCPATH = window.location.pathname;

export let pathWho;

if (LOCPATH.indexOf('/backend') > -1) {
  pathWho = 'backend';
} else {
  pathWho = 'office';
}

export function getEmployees(data) {
  let req = $.ajax({
    type     : 'POST',
    url      : '/office/get_employees',
    dataType : 'JSON',
    data     : data
  });
  return req;
}

export function checkEmail(data) {
  let req = $.ajax({
    type     : 'POST',
    url      : '/office/check_email',
    dataType : 'JSON',
    data     : data
  });
  return req;
}

export function carts(data) {
 let req = $.ajax({
    type     : 'POST',
    url      : '/office/get_calendar',
    dataType : 'JSON',
    data     : data
	});
	return req;
}

export function sendAjax(data, path) {
 let req = $.ajax({
    type     : 'POST',
    url      : path,
    dataType : 'JSON',
    data     : data
  });
  return req;
}

export function checkEmployee(data) {
 let req = $.ajax({
    type     : 'POST',
    url      : '/office/check_employee',
    dataType : 'JSON',
    data     : data
  });
  return req;
}

export function getServices(data) {
 let req = $.ajax({
    type     : 'POST',
    url      : '/office/get_services',
    dataType : 'JSON',
    data     : data
  });
  return req;
}

export function sendForm(data) {
 let req = $.ajax({
    type     : 'POST',
    url      : '/office/add_calendar',
    dataType : 'JSON',
    data     : data
  });
  return req;
}

export function sendHoliday(data) {
 let req = $.ajax({
    type     : 'POST',
    url      : '/office/add_holiday',
    dataType : 'JSON',
    data     : data
  });
  return req;
}

export function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

export function getToken() {
    return $('meta[name="csrf-token"]').attr('content');
}

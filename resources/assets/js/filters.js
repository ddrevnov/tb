import moment from 'moment'

export default {

	hourMinutes(minutes) {
		let min = +minutes % 60;
		let hours = Math.floor(+minutes / 60);
		let hoursText;
		let minutesText;
		let locale = $('meta[name="locale"]').attr('content');

		switch (locale) {
			case 'de':
				hoursText = 'uhr';
				minutesText = 'min';
				break;
			case 'en':
				hoursText = 'h';
				minutesText = 'min';
				break;
			case 'ru':
				hoursText = 'ч';
				minutesText = 'мин';
				break;
		}

		if (hours) {
			return `${hours}${hoursText} ${min}${minutesText}`;
		} else {
			return `${min}${minutesText}`;
		}
	},

	formatDate(date, format) {
		if (date === '') return '';
		 date = moment(new Date(date)).format(format);
		 return date;
	},

	noticeHeaderName(name) {
		 switch (name) {
		 		case 'admin_blocked': name = 'Blocked'; break;
		 		case 'admin_freeze': name = 'Freeze'; break;
		 		case 'change_tariff': name = 'Change tariff'; break;
		 		case 'new_registration': name = 'New registration'; break;
		 		case 'unpaid_order': name = 'Unpaid order'; break;
		 		case 'unpaid_bill': name = 'Unpaid Bill'; break;
		 		case 'delete_order': name = 'Delete order'; break;
		 		case 'new_bill': name = 'New bill'; break;
		 		case 'new_order': name = 'New Order'; break;
		 }
		 return name;
	},

	timeHM(time) {
		return moment(time).format('H:mm');
	},

	getRelativeTime(time) {
		return moment(time, "YYYY-MM-DD hh:mm:ss").startOf('minute').fromNow();
	},

	reverseArr(arr) {
		return arr.slice().reverse();
	}
}
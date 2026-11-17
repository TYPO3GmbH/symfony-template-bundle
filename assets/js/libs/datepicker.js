import { DateTime } from 'luxon';
// The styles stay in app.css, so the overrides in _datepicker.scss keep winning the cascade
require("flatpickr/dist/flatpickr.min.css");
require("flatpickr/dist/themes/light.css");

const elementsWithDatepicker = document.querySelectorAll('[data-datepicker]');
const elementsWithDateTimepicker = document.querySelectorAll('[data-datetimepicker]');
if (elementsWithDatepicker.length >= 1 || elementsWithDateTimepicker.length >= 1) {
    import('flatpickr').then(({ default: flatpickr }) => initializeDatepickers(flatpickr));
}

function initializeDatepickers(flatpickr) {
    elementsWithDatepicker.forEach(function (element) {
        const options = element.dataset.datepicker ? JSON.parse(element.dataset.datepicker) : {};
        new flatpickr(element, options);
    });

    elementsWithDateTimepicker.forEach(function (element) {

        // Convert from UTC to LocalTime before initiating the Datetimepicker
        if (element.value) {
            element.value = DateTime.fromISO(element.value, {zone: 'UTC'}).toLocal().toFormat('yyyy-MM-dd HH:mm ZZ');
        }

        const options = element.dataset.datepicker ? JSON.parse(element.dataset.datepicker) : {};
        options.enableTime = true;
        options.time_24hr = true;
        options.dateFormat = 'yyyy-MM-dd HH:mm ZZ';

        options.parseDate = (dateString, format) => {
            let dateVariants = [
                'yyyy-MM-dd HH:mm ZZ',
                'yyyy-MM-dd HH:mm',
                'yyyy-MM-dd ZZ',
                'yyyy-MM-dd'
            ];
            let date = DateTime.fromFormat(dateString, format);
            let variant = 0;
            while (!date.isValid && variant < dateVariants.length) {
                date = DateTime.fromFormat(dateString, dateVariants[variant]);
                variant++;
            };

            return date.toJSDate();
        };

        options.formatDate = (date, format) => {
            return DateTime.fromJSDate(date).toFormat(format);
        };

        new flatpickr(element, options);
    });
}

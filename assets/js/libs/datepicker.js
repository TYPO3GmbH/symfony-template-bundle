import flatpickr from "flatpickr";
import { DateTime } from 'luxon';
require("flatpickr/dist/flatpickr.min.css");
require("flatpickr/dist/themes/light.css");

Number.prototype.mins2offset = function () {
    let hours   = Math.floor(this / 60);
    let minutes = Math.floor((this - ((hours * 3600)) / 60));
    let pfx = this >= 0 ? "+" : "-";

    if (hours   < 10) hours   = "0"+hours;
    if (minutes < 10) minutes = "0"+minutes;

    return pfx+hours+':'+minutes
}

String.prototype.mins2offset = function () {
    const mins_num = parseFloat(this, 10);
    return mins_num.mins2offset();
}

const elementsWithDatepicker = document.querySelectorAll('[data-datepicker]');
if (elementsWithDatepicker.length >= 1) {
    elementsWithDatepicker.forEach(function (element) {
        const options = element.dataset.datepicker ? JSON.parse(element.dataset.datepicker) : {};
        new flatpickr(element, options);
    });
}

const elementsWithDateTimepicker = document.querySelectorAll('[data-datetimepicker]');
if (elementsWithDateTimepicker.length >= 1) {
    elementsWithDateTimepicker.forEach(function (element) {

        // Convert from UTC to LocalTime before initiating the Datetimepicker
        element.value = DateTime.fromISO(element.value, {zone: 'UTC'}).toLocal().toFormat('yyyy-MM-dd HH:mm ZZ');

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

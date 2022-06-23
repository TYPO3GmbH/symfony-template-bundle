// Load the CSS stuff
import '@fortawesome/fontawesome-free/css/fontawesome.min.css';
import '@fortawesome/fontawesome-free/css/brands.min.css';
import '@fortawesome/fontawesome-free/css/solid.min.css';
import '../css/app.scss';

// Load the JS stuff
import $ from 'jquery';
import 'bootstrap';
import 'bootstrap-tagsinput/dist/bootstrap-tagsinput';
import './libs/alert';
import './libs/popover';
import './libs/navbar';
import './libs/aggregations';
import './libs/charts';
import './libs/datepicker';
import './libs/taginput';
import './form/collection';
import './form/choices';
import './form/local_datalist';
import './form/remote_datalist';

// Syntax Highlighter
import 'prismjs';
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-bash';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-php-extras';
import 'prismjs/components/prism-nginx';
import 'prismjs/components/prism-json';
import 'prismjs/components/prism-rest';
import 'prismjs/plugins/command-line/prism-command-line';
import 'prismjs/plugins/keep-markup/prism-keep-markup';

import {DateTime, Duration} from 'luxon';

function convertDateTimes() {
    Array.from(document.querySelectorAll('[data-processor="localdatetime"]')).forEach(function (element) {
        let value = element.dataset.value;
        let text = DateTime.fromISO(value).toLocaleString({
            month: '2-digit',
            day: '2-digit',
            year: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });
        element.textContent = text;
    });
}
function convertDates() {
    Array.from(document.querySelectorAll('[data-processor="localdate"]')).forEach(function (element) {
        let value = element.dataset.value;
        let text = DateTime.fromISO(value).toLocaleString({
            month: '2-digit',
            day: '2-digit',
            year: '2-digit',
        });
        element.textContent = text;
    });
}
function convertRelativeTime() {
    Array.from(document.querySelectorAll('[data-processor="relativetime"]')).forEach(function (element) {
        let value = element.dataset.value;
        const dtTarget = DateTime.fromISO(value);
        const diff = dtTarget.diffNow(['years', 'months', 'days', 'hours', 'minutes', 'seconds']);
        const configPrototype = {
            years: diff.years,
            months: diff.months,
            days: diff.days,
            hours: diff.hours,
            minutes: diff.minutes,
        };
        // Remove "0" values
        const durationConfig = Object.fromEntries(Object.entries(configPrototype).filter(([_, v]) => v !== 0));
        let text = Duration.fromObject(durationConfig).toHuman();
        element.textContent = text;
    });
}
function initializeExpander() {
    Array.from(document.querySelectorAll('.expander')).forEach(function (element) {
        let checkbox = element.getElementsByClassName('expander-checkbox')[0];
        let content = element.getElementsByClassName('expander-content')[0];
        let inner = element.getElementsByClassName('expander-content-inner')[0];
        if (checkbox && content && inner && inner.clientHeight < content.clientHeight) {
            checkbox.checked = true;
        }
    });
}
document.onreadystatechange = function () {
    if (document.readyState == "interactive") {
        convertDates();
        convertDateTimes();
        convertRelativeTime();
        initializeExpander();
    }
}

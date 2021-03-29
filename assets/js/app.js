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
import './libs/navbar';
import './libs/aggregations';
import './libs/charts';
import './libs/datepicker';
import './form/collection';
import './form/choices';
import './form/local_datalist';
import './form/remote_datalist';

// Syntax Highlighter
import 'prismjs';
import 'prismjs/components/prism-nginx';
import 'prismjs/components/prism-json';
import 'prismjs/components/prism-rest';
import 'prismjs/plugins/command-line/prism-command-line';

import {DateTime} from 'luxon';

function convertDateTimes() {
    Array.from(document.querySelectorAll('[data-processor="localdatetime"]')).forEach(function (element) {
        const value = element.dataset.value;
        element.textContent = DateTime.fromISO(value).toLocaleString({
            month: '2-digit',
            day: '2-digit',
            year: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });
    });
}
function convertDates() {
    Array.from(document.querySelectorAll('[data-processor="localdate"]')).forEach(function (element) {
        const value = element.dataset.value;
        element.textContent = DateTime.fromISO(value).toLocaleString({
            month: '2-digit',
            day: '2-digit',
            year: '2-digit',
        });
    });
}
function convertRelativeTime() {
    Array.from(document.querySelectorAll('[data-processor="relativetime"]')).forEach(function (element) {
        const value = element.dataset.value;
        element.textContent = DateTime.fromISO(value).toRelative();
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

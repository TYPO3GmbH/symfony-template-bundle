// Load the CSS stuff
require('@fortawesome/fontawesome-free/css/fontawesome.min.css');
require('@fortawesome/fontawesome-free/css/brands.min.css');
require('@fortawesome/fontawesome-free/css/solid.min.css');
require('../css/app.scss');

// Load the JS stuff
let $ = require('jquery');
require('bootstrap');
require('bootstrap-tagsinput/dist/bootstrap-tagsinput');
require('./libs/navbar');
require('./libs/aggregations');
require('./libs/charts');
require('./form/collection');

// Syntax Highlighter
require('prismjs');
require('prismjs/components/prism-nginx');
require('prismjs/components/prism-json');
require('prismjs/components/prism-rest');

var {DateTime} = require('luxon');

function convertDates() {
    Array.from(document.querySelectorAll('[data-processor="localdate"]')).forEach(function (element) {
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
function initializeFileInput() {
    Array.from(document.querySelectorAll('.custom-file-input')).forEach(function (element) {
        element.addEventListener("change", function() {
            let fileName = this.value.split('\\').slice(-1)[0];
            let nextElement = this.nextSibling;
            if (nextElement.classList.contains('custom-file-label')) {
                nextElement.textContent = fileName
            }
        });
    });
}
document.onreadystatechange = function () {
    if (document.readyState == "interactive") {
        convertDates();
        convertRelativeTime();
        initializeExpander();
        initializeFileInput();
    }
}

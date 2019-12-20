// Load the CSS stuff
require('@fortawesome/fontawesome-free/css/fontawesome.min.css');
require('@fortawesome/fontawesome-free/css/brands.min.css');
require('@fortawesome/fontawesome-free/css/solid.min.css');
require('../css/app.scss');

// Load the JS stuff
let $ = require('jquery');
require('bootstrap');
require('./libs/navbar.js');

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
document.onreadystatechange = function () {
    if (document.readyState == "interactive") {
        convertDates();
        convertRelativeTime();
        initializeExpander();
    }
}

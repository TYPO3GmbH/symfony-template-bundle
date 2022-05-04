import Tagify from '@yaireo/tagify';

var taginputElements = [].slice.call(document.querySelectorAll('[data-taginput]'));
var taginputList = taginputElements.map(function (element) {
    const options = element.dataset.taginput ? JSON.parse(element.dataset.taginput) : {};
    const tagify = new Tagify(element, options);
    element.addEventListener('focus', function () {
        tagify.DOM.input.focus();
    });
    return tagify;
})

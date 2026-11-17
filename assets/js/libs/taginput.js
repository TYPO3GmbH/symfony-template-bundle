const taginputElements = [].slice.call(document.querySelectorAll('[data-taginput]'));
if (taginputElements.length >= 1) {
    import('@yaireo/tagify').then(({ default: Tagify }) => {
        taginputElements.forEach(function (element) {
            const options = element.dataset.taginput ? JSON.parse(element.dataset.taginput) : {};
            const tagify = new Tagify(element, options);
            element.addEventListener('focus', function () {
                tagify.DOM.input.focus();
            });
        });
    });
}

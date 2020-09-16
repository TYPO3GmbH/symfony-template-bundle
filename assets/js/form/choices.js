(function() {
    const elementsWithChoicesJs = document.querySelectorAll('[data-choicesjs]');
    if (elementsWithChoicesJs.length >= 1) {
        const Choices = require('choices.js');
        elementsWithChoicesJs.forEach(function (element) {
            const options = element.dataset.choicesjs ? JSON.parse(element.dataset.choicesjs) : {};
            new Choices(element, options);
        });
    }
})();

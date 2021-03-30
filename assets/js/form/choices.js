(function() {
    const elementsWithChoicesJs = document.querySelectorAll('[data-choicesjs]');
    if (elementsWithChoicesJs.length >= 1) {
        const Choices = require('choices.js');
        elementsWithChoicesJs.forEach(function (element) {
            const options = element.dataset.choicesjs ? JSON.parse(element.dataset.choicesjs) : {};
            const choices = new Choices(element, options);
            element.addEventListener('set-choices-value', function(e) {
                const value = e.detail.value;
                choices.setChoiceByValue(value);
            });
        });
    }
})();

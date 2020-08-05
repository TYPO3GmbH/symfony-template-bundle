(function() {
    const elementsWithDatepicker = document.querySelectorAll('[data-datepicker]');
    if (elementsWithDatepicker.length >= 1) {
        import('vanillajs-datepicker').then(({ Datepicker }) => {
            elementsWithDatepicker.forEach(function (element) {
                const options = element.dataset.datepicker ? JSON.parse(element.dataset.datepicker) : {};
                options.buttonClass = 'btn';
                options.format = 'yyyy-MM-dd';
                new Datepicker(element, options);
            });
        }).catch(error => 'An error occurred while loading the datepicker component');
    }
})();

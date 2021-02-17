(function () {
    const localDatalistInputs = document.querySelectorAll('input[list]:not([data-source-url])');
    for (let localDatalistInput of localDatalistInputs) {
        localDatalistInput.addEventListener('input', function (e) {
            const inputField = e.target;
            const connectedDatalist = document.getElementById(inputField.getAttribute('list'));

            if (typeof e.which === 'undefined') {
                // e.which is undefined, which indicates the value was added from a datalist

                const option = connectedDatalist.querySelector('[value="' + inputField.value + '"]')
                const optionValue = option.dataset.value;

                const valueField = document.getElementById(inputField.dataset.valueField);
                valueField.value = optionValue;

                return;
            }
        });
    }
})();

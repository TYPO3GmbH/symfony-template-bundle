(function () {
    const debounce = (func, wait) => {
        let timeout;

        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };

            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    const remoteDatalistInputs = document.querySelectorAll('input[list][data-source-url]');
    for (let remoteDatalistInput of remoteDatalistInputs) {
        remoteDatalistInput.addEventListener('input', debounce(async function (e) {
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

            if (inputField.dataset.lastSearch !== '' && inputField.value.startsWith(inputField.dataset.lastSearch)) {
                // The input that invoked a server-side search loaded a superset of the results that include the
                // narrowed down result set of the current input. Since browsers already take care of filtering
                // datalists based on their input, we have nothing to do here.
                return;
            }

            while (connectedDatalist.firstChild) {
                connectedDatalist.removeChild(connectedDatalist.lastChild);
            }

            if (inputField.value.length < 3) {
                return;
            }

            const params = new URLSearchParams();
            params.set(inputField.dataset.searchParam, inputField.value);

            const url = `${window.location.origin}/${inputField.dataset.sourceUrl}?${params.toString()}`;
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw Error(response.statusText);
            }

            inputField.setAttribute('data-last-search', inputField.value);

            const json = await response.json();
            for (const entry of Object.values(json)) {
                const optionElement = document.createElement('option');
                optionElement.setAttribute('data-value', entry.value);
                optionElement.value = entry.label;
                connectedDatalist.appendChild(optionElement);
            }
        }, 500));
    }
})();

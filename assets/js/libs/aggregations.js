(function() {
    'use strict';

    const localStorageKey = 'aggregations';
    const visibilityPrefix = 'aggregation.visible.';
    const Selectors = {
        aggregationContainer: '#aggregations'
    };

    $(function () {
        Aggregations.initialize();
    });

    const Aggregations = {
        initialize: function () {
            if (document.querySelector(Selectors.aggregationContainer) !== null) {
                Aggregations.initializeEvents();
                Aggregations.toggleVisibility();
            }
        },
        initializeEvents: function () {
            $(Selectors.aggregationContainer).on('show.bs.collapse', function (e) {
                const id = e.target.id;
                Aggregations.setStorage(visibilityPrefix + id, true);
            }).on('hide.bs.collapse', function (e) {
                const id = e.target.id;
                Aggregations.setStorage(visibilityPrefix + id, false);
            });
        },
        toggleVisibility: function () {
            const storage = Aggregations.getStorage();
            if (Object.values(storage).length > 0) {
                for (let item in storage) {
                    if (storage.hasOwnProperty(item) && item.indexOf(visibilityPrefix) > -1) {
                        const value = storage[item];
                        const aggregationContainerId = '#' + item.substring(visibilityPrefix.length);
                        $(aggregationContainerId).collapse(value ? 'show' : 'hide');
                    }
                }
            } else {
                // Nothing in localStorage, toggle first accordion
                $(Selectors.aggregationContainer).find('[data-parent="' + Selectors.aggregationContainer + '"]:first').collapse('show');
            }
        },
        getStorage: function() {
            return JSON.parse(localStorage.getItem(localStorageKey) || '{}');
        },
        setStorage: function (identifier, value) {
            const storage = Aggregations.getStorage();
            storage[identifier] = value;

            localStorage.setItem(localStorageKey, JSON.stringify(storage));
        }
    };
})();

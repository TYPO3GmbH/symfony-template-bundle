(function() {
    'use strict';

    const Selectors = {
        chartContainer: 'canvas.js-chart'
    };

    const Charts = {
        initialize: function () {
            if (document.querySelectorAll(Selectors.chartContainer).length > 0) {
                require('chart.js');
                Charts.setup();
            }
        },
        setup: function () {
            const charts = Array.from(document.querySelectorAll(Selectors.chartContainer));
            for (let canvas of charts) {
                Charts.loadChart(canvas);
            }
        },
        loadChart: function (canvas) {
            const chartType = canvas.dataset.chartType;
            const sourceUrl = canvas.dataset.src;
            const options = JSON.parse(canvas.dataset.options || '{}');

            Charts.fetchData(sourceUrl).done(function(response) {
                new Chart(canvas, {
                    type: chartType,
                    data: response,
                    options: Object.assign({
                        responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: 'index'
                        }
                    }, options)
                });
            });
        },
        fetchData: function (src) {
            return $.ajax(src, {
                dataType: 'json'
            });
        }
    };

    $(function () {
        Charts.initialize();
    });
})();

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

const Charts = {
    options: {
        selector: 'canvas.js-chart'
    },
    initialize: function () {
        if (document.querySelectorAll(this.options.selector).length > 0) {
            Charts.setup();
        }
    },
    setup: function () {
        const charts = Array.from(document.querySelectorAll(this.options.selector));
        for (let canvas of charts) {
            Charts.loadChart(canvas);
        }
    },
    loadChart: function (canvas) {
        const chartType = canvas.dataset.chartType;
        const sourceUrl = canvas.dataset.src || null;
        const dataSet = JSON.parse(canvas.dataset.dataset || '{}');
        const options = JSON.parse(canvas.dataset.options || '{}');

        if (sourceUrl) {
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
        } else if (dataSet) {
            new Chart(canvas, {
                type: chartType,
                data: dataSet,
                options: Object.assign({
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index'
                    }
                }, options)
            });
        }
    },
    fetchData: function (src) {
        return fetch(src).json();
    }
};

Charts.initialize();

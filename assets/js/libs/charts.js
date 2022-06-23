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
    loadChart: async function (canvas) {
        let chartType = canvas.dataset.chartType;
        let sourceUrl = canvas.dataset.src || null;
        let dataSet = JSON.parse(canvas.dataset.dataset || '{}');
        let options = JSON.parse(canvas.dataset.options || '{}');

        if (sourceUrl) {
            dataSet = await this.fetchData(sourceUrl);
        }

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
    },
    fetchData: async function (src) {
        let response = await fetch(src, {
            headers: {
              'Accept': 'application/json'
            }
        });
        let data = await response.json();
        return data;
    }
};

Charts.initialize();

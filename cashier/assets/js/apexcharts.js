let loc = window.location.pathname.split('/');
let currLoc = loc[loc.length - 1];
if (currLoc === 'dashboard.php') {
    var options = {
        chart: {
            type: 'pie'
        },
        series: [44, 55, 13, 33],
        labels: ['Apple', 'Mango', 'Orange', 'Watermelon']
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();

    options = {
        chart: {
            type: 'bar'
        },
        plotOptions: {
            bar: {
                horizontal: true
            }
        },
        series: [{
            data: [{
                x: 'category A',
                y: 10
            }, {
                x: 'category B',
                y: 18
            }, {
                x: 'category C',
                y: 13
            }]
        }]
    }

    var chart = new ApexCharts(document.querySelector("#column-chart"), options);

    chart.render();
}

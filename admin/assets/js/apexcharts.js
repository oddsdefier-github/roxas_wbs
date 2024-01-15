let loc = window.location.pathname.split('/');
let currLoc = loc[loc.length - 1];
if (currLoc === 'dashboard.php') {


    function retrieveRevenue() {
        $.ajax({
            url: 'charts_data.php',
            type: 'post',
            dataType: 'json',
            data: {
                action: 'getRevenue'
            },
            success: function (data) {
                console.log(data);

                var options = {
                    series: [],
                    chart: {
                        type: 'bar',
                        fontFamily: "Inter, sans-serif",
                        dropShadow: {
                            enabled: false,
                        },
                        height: 550
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: true
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: [],
                    },
                    yaxis: {
                        title: {
                            text: ''
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "₱ " + val
                            }
                        }
                    }
                };

                data.forEach(item => {
                    var existingSeries = options.series.find(series => series.name === item.transactionType);

                    if (existingSeries) {
                        existingSeries.data.push(parseFloat(item.totalRevenue));
                    } else {
                        options.series.push({
                            name: item.transactionType,
                            data: [parseFloat(item.totalRevenue)]
                        });
                    }

                    if (!options.xaxis.categories.includes(item.month)) {
                        options.xaxis.categories.push(item.month);
                    }
                });

                var chart = new ApexCharts(document.querySelector("#barchart"), options);
                chart.render();
            }
        });
    }

    retrieveRevenue();

    function retrieveClients() {
        $.ajax({
            url: 'charts_data.php',
            type: 'post',
            dataType: 'json',
            data: {
                action: 'getClients'
            },
            success: function (data) {

                var seriesData = data.map(item => parseInt(item.totalClients));
                var labelsData = data.map(item => item.brgy);

                var options = {
                    series: seriesData,
                    chart: {
                        width: 500,
                        height: 500,
                        fontFamily: "Inter, sans-serif",
                        type: 'pie',
                    },
                    labels: labelsData,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#pie-chart"), options);
                chart.render();
            }
        });
    }
    retrieveClients();

    function retrieveConsumption() {
        $.ajax({
            url: 'charts_data.php',
            type: 'post',
            dataType: 'json',
            data: {
                action: 'getConsumption'
            },
            success: function (data) {
                console.log(data);

                var options = {
                    series: [{
                        name: "Consumption",
                        data: []
                    }],
                    chart: {
                        height: 500,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [],
                    }
                };

                data.forEach(item => {
                    options.series[0].data.push(parseFloat(item.totalConsumption));
                    options.xaxis.categories.push(item.month);
                });

                var chart = new ApexCharts(document.querySelector("#line-chart"), options);
                chart.render();
            }
        });
    }

    // Call the function to retrieve and render consumption data
    retrieveConsumption();
}





function generateChartData() {
    $.ajax({
        url: './charts_data.php',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'getChartsData'
        },
        success: function (data) {
            console.log(data)
        }
    })
}

generateChartData();
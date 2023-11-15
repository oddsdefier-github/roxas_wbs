function generateRevenueReports(action, dataParam) {
    const { table, type, column, value, startDate, endDate } = dataParam;
    $.ajax({
        url: "report_generation_action.php",
        type: "POST",
        data: {
            action: action,
            dataParam: {
                table: table,
                type: type,
                column: column,
                value: value,
                startDate: startDate,
                endDate: endDate
            }
        },
        success: function (data) {
            console.log(data);
            var responseData = JSON.parse(data);
            console.log(responseData);
            if (responseData.status === 'success') {
                var pdfPath = responseData.path;
                var dynamicFilename = responseData.filename;
                downloadPDF(pdfPath, dynamicFilename);
            } else {
                console.error("Error in report generation:", responseData.error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}

function downloadPDF(pdfPath, dynamicFilename) {
    var link = document.createElement("a");
    link.href = pdfPath;
    link.download = dynamicFilename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function callback(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }


    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
            'Last 12 Months': [moment().subtract(12, 'months').startOf('month'), moment().endOf('month')]
        }

    }, callback);

    $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
        const startDate = picker.startDate.format('YYYY-MM-DD');
        const endDate = picker.endDate.format('YYYY-MM-DD');
    });

    callback(start, end);

    $("#gen_report").on('click', function () {
        const startDate = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        const endDate = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');

        const action = 'generateRevenueReports';

        const applicationRevenue = {
            table: 'transactions',
            type: 'application',
            column: 'transaction_type',
            value: 'application_payment',
            startDate: startDate,
            endDate: endDate
        }
        const billingRevenue = {
            table: 'transactions',
            type: 'billing',
            column: 'transaction_type',
            value: 'bill_payment',
            startDate: startDate,
            endDate: endDate
        }

        const allRevenue = {
            table: 'transactions',
            type: 'all',
            column: '',
            value: '',
            startDate: startDate,
            endDate: endDate
        }

        const category = $("#report_category").val();
        console.log(category)
        switch (category) {
            case 'application_revenue':
                generateRevenueReports(action, applicationRevenue);
                break;
            case 'billing_revenue':
                generateRevenueReports(action, billingRevenue);
                break;
            case 'all_revenue':
                generateRevenueReports(action, allRevenue);
                break;
        }

    });
});

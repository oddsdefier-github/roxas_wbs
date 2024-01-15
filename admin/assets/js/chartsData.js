
function generateChartData() {
    $.ajax({
        url: './charts_data.php',
        type: 'post',
        dataType: 'json',
        data: {
            action: 'getChartsData'
        },
        success: function (data) {
            updateChartsData(data);
        }
    })
}

generateChartData();


function updateChartsData(data) {
    const totalClients = $('#total_clients');
    const activeClients = $('#active_clients');
    const underReviewClients = $('#under_review_clients');
    const inactiveClients = $('#inactive_clients');
    const totalRevenue = $('#total_revenue');
    const applicationRev = $('#application_rev');
    const billingRev = $('#billing_rev')
    const totalApplication = $('#total_application');
    const unconfirmedApp = $('#unconfirmed_app');
    const confirmedApp = $('#confirmed_app');
    const approvedApp = $('#approved_app');
    const totalConsumption = $('#total_consumption');
    const commercialConsumption = $('#commercial_consumption');
    const residentialConsumption = $('#residential_consumption');

    const { active, under_review, inactive, total_clients, application_rev, billing_rev, total_rev, unconfirmed_app, confirmed_app, approved_app, total_application, residential_consumption, commercial_consumption, total_consumption } = data;


    totalClients.text(total_clients);
    activeClients.text(active);
    underReviewClients.text(under_review)
    inactiveClients.text(inactive);
    totalRevenue.text('₱ ' + total_rev.toLocaleString('en-PH'));
    applicationRev.text('₱ ' + application_rev.toLocaleString('en-PH'));
    billingRev.text('₱ ' + billing_rev.toLocaleString('en-PH'));
    totalApplication.text(total_application);
    unconfirmedApp.text(unconfirmed_app);
    confirmedApp.text(confirmed_app);
    approvedApp.text(approved_app);
    totalConsumption.text(total_consumption);
    commercialConsumption.text(commercial_consumption);
    residentialConsumption.text(residential_consumption);
}

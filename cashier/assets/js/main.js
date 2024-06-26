import { DataTableWithPagination } from './DataTableWithPagination.js';


$(document).ready(function () {
    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    if (filename === 'billing_payments.php') {
        const billingTable = new DataTableWithPagination("billing_data", '#displayBillingTable');
    } else if (filename === 'application_payments.php') {
        const clientAppBillingTable = new DataTableWithPagination("client_application", '#displayClientAppBillingTable');
    } else if (filename === 'reports.php') {
        const reportsTable = new DataTableWithPagination("reports", '#displayReportsTable');
    }

    $('.cashiers_nav').each(function () {
        $(this).find('a').each(function () {
            const linkHref = $(this).attr('href');
            const linkFilename = linkHref.substring(linkHref.lastIndexOf('/') + 1);

            if (linkFilename === filename) {
                $(this).removeClass('inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50').addClass('inline-block font-bold p-4 text-primary-700 bg-primary-100 rounded-t-lg active');
            }
        });
    });

    if (filename === 'billing_payments.php') {
        $("#billingFilter").show();
        $("#qrBilling").show();
    } else {
        $("#billingFilter").hide();
        $("#qrBilling").hide();
    }
    filename === 'application_payments.php' ? $("#clientAppFilter").show() : $("#clientAppFilter").hide();


});


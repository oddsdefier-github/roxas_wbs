import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {
    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);
    console.log(`Current Filename: ${filename}`); // Debugging line

    if (filename === 'billing_payments.php') {
        const billingTable = new DataTableWithPagination("billing_data", '#displayBillingTable');
    } else if (filename === 'application_payments.php') {
        const clientAppBillingTable = new DataTableWithPagination("client_application", '#displayClientAppBillingTable');
    }

    $('.payments_nav').find('a').each(function () {
        const linkHref = $(this).attr('href');
        const linkFilename = linkHref.substring(linkHref.lastIndexOf('/') + 1);

        console.log(`Link Filename: ${linkFilename}`); // Debugging line

        if (linkFilename === filename) {
            console.log('Match Found: Applying Styles'); // Debugging line
            $(this).removeClass('inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50').addClass('inline-block p-4 text-primary-600 bg-gray-100 rounded-t-lg active');
        }
    });
});

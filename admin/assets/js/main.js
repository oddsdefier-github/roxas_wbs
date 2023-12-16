import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {
    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    let table;

    switch (filename) {
        case 'clients.php':
            table = new DataTableWithPagination("client_data", '#displayClientDataTable');
            $("#clientFilter").show();
            break;
        case 'clients_application_table.php':
            table = new DataTableWithPagination("client_application", '#displayClientApplicationTable');
            $("#clientAppFilter").show();
            break;
        case 'transactions.php':
            table = new DataTableWithPagination("transactions", '#displayTxTable');
            $("#transactionFilter").show();
            break;
        case 'billing.php':
            handleBillingPage();
            break;
        case 'meter_reports.php':
            table = new DataTableWithPagination("meter_reports", '#displayMeterReportsTable');
            break;
        default:
            break;
    }

    $('.page_nav').each(function () {
        $(this).find('a').each(function () {
            const linkHref = $(this).attr('href');
            const linkFilename = linkHref.substring(linkHref.lastIndexOf('/') + 1);

            if (linkFilename === filename) {
                $(this).removeClass('inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50').addClass('inline-block font-bold p-4 text-primary-700 bg-primary-100 rounded-t-lg active');
            }
        });
    });


    function handleBillingPage() {
        const currentURL = window.location.href;
        const urlParts = currentURL.split('/');
        const lastPart = urlParts[urlParts.length - 1];

        if (lastPart === 'billing.php') {
            localStorage.removeItem('clientID');
            table = new DataTableWithPagination("billing", '#displayBillingTable');
        } else if (lastPart === 'transactions.php') {
            localStorage.removeItem('clientID');
            table = new DataTableWithPagination("transactions", '#displayTxTable');
        }
    }
    handleBillingPage();

});


function openPage(event, id, page) {
    if (event.target.tagName === 'BUTTON' || event.target.closest('svg')) { return }

    const textSelected = window.getSelection().toString().length > 0;

    if (textSelected) {
        return;
    }
    localStorage.setItem('clientID', id);
    window.location.href = `${page}?id=${id}`;
}

window.openPage = openPage;
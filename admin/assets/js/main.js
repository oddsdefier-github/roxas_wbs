import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {
    const filterConfig = {
        clientTable:
            [
                {
                    column: "status",
                    value: "Active"
                }
            ],
        clientAppTable:
            [
                {
                    column: "status",
                    value: "Unconfirmed"
                }
            ]
    }
    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    if (filename === 'clients.php') {
        const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable', filterConfig.clientTable);
    } else if (filename === 'clients_application_table.php') {
        const clientAppBillingTable = new DataTableWithPagination("client_application", '#displayClientApplicationTable', filterConfig.clientAppTable);
    }

    $('.page_nav').each(function () {
        $(this).find('a').each(function () {
            const linkHref = $(this).attr('href');
            const linkFilename = linkHref.substring(linkHref.lastIndexOf('/') + 1);

            if (linkFilename === filename) {
                $(this).removeClass('inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50').addClass('inline-block font-bold p-4 text-primary-700 bg-primary-100 rounded-t-lg active');
            }
        });
    })

    filename === 'clients_application_table.php' ? $("#clientAppStatusFilter").show() : $("#clientAppStatusFilter").hide();
    filename === 'clients.php' ? $("#clientStatusFilter").show() : $("#clientStatusFilter").hide();
});
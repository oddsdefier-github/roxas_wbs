import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {
    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    if (filename === 'clients.php') {
        const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable');
    } else if (filename === 'clients_application_table.php') {
        const clientAppBillingTable = new DataTableWithPagination("client_application", '#displayClientApplicationTable');
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

function openPage(event, id, page) {
    if (event.target.tagName === 'BUTTON' || event.target.closest('svg')) { return }

    const textSelected = window.getSelection().toString().length > 0;

    if (textSelected) {
        return;
    }

    console.log(id);
    let location = window.location.href;
    console.log(location);
    window.location.href = `${page}?id=${id}`;
}

window.openPage = openPage;
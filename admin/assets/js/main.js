import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {
    const urlToTableNameMapping = {
        "clients.php": "client_data",
        "clients_application.php": "client_application",
    };

    let parts = window.location.pathname.split('/');
    let filename = parts[parts.length - 1];
    let tableName = urlToTableNameMapping[filename];
    if (tableName) {
        $('.pagination-container').attr('data-table-name', tableName);
        $('.table-utilities-container').attr('data-table-name', tableName);
    }

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
    const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable', filterConfig.clientTable);
    const clientAppTable = new DataTableWithPagination("client_application", '#displayClientApplicationTable', filterConfig.clientAppTable);


    filename === 'clients_application.php' ? $("#clientAppStatusFilter").show() : $("#clientAppStatusFilter").hide();
    filename === 'clients.php' ? $("#clientStatusFilter").show() : $("#clientStatusFilter").hide();
});
import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {
    const urlToTableNameMapping = {
        "clients.php": "client_data",
        "clients_application.php": "client_application",
    };

    let parts = window.location.pathname.split('/');
    let filename = parts[parts.length - 1];
    let tableName = urlToTableNameMapping[filename];
    console.log(tableName)
    console.log(filename)
    if (tableName) {
        $('.pagination-container').attr('data-table-name', tableName);
        $('.table-utilities-container').attr('data-table-name', tableName);
    }
    const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable');
    const clientAppTable = new DataTableWithPagination("client_application", '#displayClientApplicationTable');

    console.log(clientTable);
    console.log(clientAppTable);


});
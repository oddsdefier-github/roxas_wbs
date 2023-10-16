import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {

    $('.pagination-container').attr('data-table-name', 'billing_data');
    $('.table-utilities-container').attr('data-table-name', 'billing_data');
    const clientTable = new DataTableWithPagination("client_data", '#displayClientForBilling');

});
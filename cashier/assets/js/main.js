import { DataTableWithPagination } from './DataTableWithPagination.js';

$(document).ready(function () {
    const billingTable = new DataTableWithPagination("billing_data", '#displayBillingTable');
    const clientAppBillingTable = new DataTableWithPagination("client_application", '#displayClientAppBillingTable');
});


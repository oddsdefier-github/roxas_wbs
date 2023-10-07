import { DataTableWithPagination } from './DataTableWithPagination.js';

const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable');

document.addEventListener('DOMContentLoaded', () => {
    $('#display_client_app_table').on('click', () => {
        console.log('✈')
        const clientAppTable = new DataTableWithPagination("client_application");
    })
})
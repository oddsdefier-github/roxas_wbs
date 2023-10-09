import { DataTableWithPagination } from './DataTableWithPagination.js';

const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable');


document.addEventListener('DOMContentLoaded', () => {
    $('button[data-utils="load-table"]').on('click', () => {
        console.log('✈')
        const clientAppTable = new DataTableWithPagination("client_application");
    });
})


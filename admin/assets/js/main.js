import { DataTableWithPagination } from './DataTableWithPagination.js';

const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable');
const clientAppTable = new DataTableWithPagination("client_application");

document.addEventListener('DOMContentLoaded', () => {
    function displayClientAppTable() {
        clientAppTable
    }

    $('#display_client_app_table').on('click', () => {
        console.log('✈')
        displayClientAppTable()
    })
})
import { DataTableWithPagination } from './DataTableWithPagination.js';
class DeleteHandler {
    constructor (delId, tableName) {
        this.deleteModal = $('#deleteClientModal');
        this.id = delId;
        this.tableName = tableName;
    }


    showModal() {
        $.ajax({
            url: "database_actions.php",
            type: "post",
            dataType: 'json',
            data: {
                action: "getName",
                id: this.id,
                tableName: this.tableName
            },
            success: (data) => {
                const fullName = data.full_name;
                $("span[data-delete-name]").text(fullName);
            },
            error: (error) => {
                console.log("Error fetching name:", error);
            }
        });

        this.deleteModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });
    }


    hideModal() {
        this.deleteModal.css('display', 'none');
    }

    deleteItem() {
        this.showModal();

        $('.confirm-delete').off('click');
        $('#cancelDeleteButton').off('click');

        $('.confirm-delete').on('click', () => {
            console.log("CONFIRMDELETEBUTTON IS BEING CLICKED");
            this.executeDeletion();
            this.hideModal();
        });

        $('#cancelDeleteButton').on('click', () => {
            this.hideModal();
        });
    }
}


class EnhancedDeleteHandler extends DeleteHandler {
    constructor (delId, tableName, tableInstance) {
        super(delId, tableName);
        this.tableInstance = tableInstance;
    }
    executeDeletion() {

        const currentPath = window.location.pathname;
        const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);

        let searchKey = '';
        let filterKey = '';

        if (filename === 'clients.php') {
            searchKey = '#displayClientDataTable-searchKey';
            filterKey = '#displayClientDataTable-filterKey';
        } else if (filename === 'clients_application_table.php') {
            searchKey = '#displayClientApplicationTable-searchKey';
            filterKey = '#displayClientApplicationTable-filterKey';
        }
        const savedSearch = localStorage.getItem(searchKey) || "";
        const savedFilter = JSON.parse(localStorage.getItem(filterKey)) || [];
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "deleteItem",
                id: this.id,
                tableName: this.tableName
            },
            success: (data) => {
                alert(data);
                this.tableInstance.fetchTableData(savedSearch, savedFilter);
            }
        });
    }
}


function deleteClient(delId, tableName) {
    const clientTable = new DataTableWithPagination(tableName, '#displayClientDataTable');
    const handler = new EnhancedDeleteHandler(delId, tableName, clientTable);
    handler.deleteItem();
}
function deleteClientApplication(delId, tableName) {
    const clientTable = new DataTableWithPagination(tableName, '#displayClientApplicationTable');
    const handler = new EnhancedDeleteHandler(delId, tableName, clientTable);
    handler.deleteItem();
}

window.deleteClient = deleteClient;
window.deleteClientApplication = deleteClientApplication;

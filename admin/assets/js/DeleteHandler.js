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
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "deleteItem",
                id: this.id,
                tableName: this.tableName
            },
            success: (data) => {
                console.log(data);
                this.tableInstance.fetchTableData();
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

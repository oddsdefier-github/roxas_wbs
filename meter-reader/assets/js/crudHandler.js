class EncodeHandler {
    constructor (clientID, tableName) {
        this.encodeReadingDataModal = $('#encodeReadingDataModal');
        this.id = clientID;
        this.tableName = tableName;
    }

    showModal() {
        this.encodeReadingDataModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });
    }


    hideModal() {
        this.encodeReadingDataModal.css('display', 'none');
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


class viewHandler {
    constructor (clientID, tableName) {
        this.viewReadingDataModal = $('#viewReadingDataModal');
        this.id = clientID;
        this.tableName = tableName;
    }

    showModal() {
        this.viewReadingDataModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });
    }


    hideModal() {
        this.viewReadingDataModal.css('display', 'none');
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


function encodeReadingData(clientID, tableName) {
    const handler = new EncodeHandler(clientID, tableName, "client-data");
    handler.deleteItem();
}

function viewReadingData(clientID, tableName) {
    const handler = new viewHandler(clientID, tableName, "client-data");
    handler.deleteItem();
}


window.encodeReadingData = encodeReadingData;
window.viewReadingData = viewReadingData;


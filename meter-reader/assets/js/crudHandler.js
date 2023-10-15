class EncodeHandler {
    constructor (clientID) {
        this.encodeReadingDataModal = $('#encodeReadingDataModal');
        this.client_id = clientID;
    }

    showModal() {
        const self = this
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "retrieveClientData",
                clientID: this.client_id,
            },
            success: function (data) {
                const parsedData = JSON.parse(data);
                self.handleData(parsedData);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + ": " + error);
            }
        });

        this.encodeReadingDataModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });


    }

    handleData(responseData) {
        console.log(responseData)
    }

    hideModal() {
        this.encodeReadingDataModal.css('display', 'none');
    }

    retrieveData() {
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


function encodeReadingData(clientID) {
    const handler = new EncodeHandler(clientID);
    console.log(clientID)
    handler.retrieveData();
}

function viewReadingData(clientID) {
    const handler = new viewHandler(clientID);
    handler.deleteItem();
}


window.encodeReadingData = encodeReadingData;
window.viewReadingData = viewReadingData;


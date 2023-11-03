class EncodeHandler {
    constructor (clientID) {
        this.encodeReadingDataModal = $('#encodeReadingDataModal');
        this.client_id = clientID;

        this.elements = {
            fullName: $('.full_name'),
            statusBadge: $('.status_badge'),
            propertyType: $('.property_type'),
            meterNumber: $('.meter_number'),
            prevReading: $('#prev-reading'),
            submitEncode: $('.submit_encode'),
            clientProfileLink: $('.client_profile_link'),
            encodeReadingModal: $('#encodeReadingDataModal'),
            consumptionInput: $('#consumption'),
            prevReadingInput: $('#prev-reading'),
            currReadingInput: $('#curr-reading'),
            encodeForm: $('.encode_form')
        };
        this.badgeElements = {
            active: `<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
            <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
            Active </span>`,
            inactive: `<span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
            <span class="w-2 h-2 mr-1 bg-red-500 rounded-full"></span>
            Inactive </span>`
        };

        const self = this;

        this.elements.currReadingInput.on('input', function () {
            const prevReading = self.elements.prevReadingInput.val();
            console.log(prevReading);
            const currReading = self.elements.currReadingInput.val();
            const computeConsumption = +currReading - +prevReading;
            self.elements.consumptionInput.val(`${computeConsumption} cubic meter`);
        });

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
                self.encodeCurrentReading(parsedData);
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
        const self = this;
        console.log(responseData)

        const clientProfileLink = `./client_profile.php?id=${this.client_id}`

        const fullName = responseData.full_name;
        const status = responseData.status;
        const propertyType = responseData.property_type;
        const meterNumber = responseData.meter_number;


        this.elements.fullName.text(fullName)
        status === 'active' ? this.elements.statusBadge.html(this.badgeElements.active) : this.elements.statusBadge.html(this.badgeElements.inactive);
        status === 'inactive' ? this.elements.submitEncode.prop('disabled', true) : this.elements.submitEncode.prop('disabled', false);

        
        this.elements.propertyType.text(propertyType);
        this.elements.meterNumber.text(meterNumber);
        this.elements.clientProfileLink.attr('href', clientProfileLink);
        this.elements.prevReading.val(responseData.recent_meter_reading)
        self.handleStatus(status);
    }

    validateReadingInput() {

    }
    encodeCurrentReading(responseData) {
        const self = this;

        this.elements.encodeForm.off('submit').on('submit', function (e) {
            e.preventDefault();


            if (self.elements.currReadingInput.val().trim() == '') {
                console.log('EMPTYYY')

            } else {
                console.log(responseData);
                const clientID = responseData.client_id;
                const propertyType = responseData.property_type;
                const meterNumber = responseData.meter_number;
                const prevReading = self.elements.prevReadingInput.val();
                const currReading = self.elements.currReadingInput.val();
                let consumption = self.elements.consumptionInput.val();
                consumption = consumption.split(" ")[0];

                console.log(consumption);

                $.ajax({
                    url: "database_actions.php",
                    type: "post",
                    data: {
                        action: "encodeMeterReadingData",
                        formData: {
                            clientID: clientID,
                            prevReading: prevReading,
                            currReading: currReading,
                            propertyType: propertyType,
                            meterNumber: meterNumber,
                            consumption: consumption
                        }
                    },
                    success: function (data) {
                        console.log(data)
                        self.elements.currReadingInput.val("")
                        self.hideModal();
                        // window.location.reload()
                    }
                })
            }

        });
    }

    handleStatus(status) {
        console.log(status)
        if (status == 'active') {
            $('#curr-reading').prop('disabled', false)
        } else {
            $('#curr-reading').prop('disabled', true)
        }
    }

    hideModal() {
        this.encodeReadingDataModal.css('display', 'none');
    }
}


// class viewHandler {
//     constructor (clientID, tableName) {
//         this.viewReadingDataModal = $('#viewReadingDataModal');
//         this.id = clientID;
//         this.tableName = tableName;
//     }

//     showModal() {
//         this.viewReadingDataModal.css({
//             'display': 'grid',
//             'place-items': 'center',
//             'justify-content': 'center',
//             'align-items': 'center'
//         });
//     }


//     hideModal() {
//         this.viewReadingDataModal.css('display', 'none');
//     }

//     deleteItem() {
//         this.showModal();

//         $('.confirm-delete').off('click');
//         $('#cancelDeleteButton').off('click');

//         $('.confirm-delete').on('click', () => {
//             console.log("CONFIRMDELETEBUTTON IS BEING CLICKED");
//             this.executeDeletion();
//             this.hideModal();
//         });

//         $('#cancelDeleteButton').on('click', () => {
//             this.hideModal();
//         });
//     }
// }


function encodeReadingData(clientID) {
    const handler = new EncodeHandler(clientID);
    console.log(clientID)
    handler.showModal();
}

function viewReadingData(clientID) {
    const handler = new viewHandler(clientID);
    handler.deleteItem();
}


window.encodeReadingData = encodeReadingData;
window.viewReadingData = viewReadingData;


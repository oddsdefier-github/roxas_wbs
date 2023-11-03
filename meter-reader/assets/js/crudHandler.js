import { DataTableWithPagination } from './DataTableWithPagination.js';
class EncodeHandler {
    constructor (clientID, tableDisplay) {
        this.client_id = clientID;

        this.initializeElements();
        this.bindEvents();
        this.retrieveData();
        this.showModal();
        this.tableDisplay = tableDisplay;
    }

    initializeElements() {
        this.encodeReadingDataModal = $('#encodeReadingDataModal');
        this.badgeElements = {
            active: `<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
            <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
            Active </span>`,
            inactive: `<span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
            <span class="w-2 h-2 mr-1 bg-red-500 rounded-full"></span>
            Inactive </span>`
        };
        this.elements = {
            fullName: $('.full_name'),
            statusBadge: $('.status_badge'),
            propertyType: $('.property_type'),
            meterNumber: $('.meter_number'),
            prevReading: $('#prev-reading'),
            submitEncode: $('.submit_encode'),
            clientProfileLink: $('.client_profile_link'),
            currReadingInput: $('#curr-reading'),
            consumptionInput: $('#consumption'),
            prevReadingInput: $('#prev-reading'),
            encodeForm: $('.encode_form')
        };
    }

    bindEvents() {
        this.elements.currReadingInput.on('input', () => {
            const prevReading = this.elements.prevReadingInput.val();
            const currReading = this.elements.currReadingInput.val();
            const computeConsumption = +currReading - +prevReading;
            this.elements.consumptionInput.val(`${computeConsumption} cubic meter`);
        });
    }

    retrieveData() {
        const self = this;
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data:
            {
                action: "retrieveClientData",
                clientID: this.client_id
            },
            success: function (data) {
                const responseData = JSON.parse(data);
                self.updateUI(responseData);
                self.encodeCurrentReading(responseData);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + ": " + error);
            }
        });
    }

    showModal() {
        this.encodeReadingDataModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });
    }

    handleStatus(status) {
        $('#curr-reading').prop('disabled', status !== 'active');
    }

    updateUI(responseData) {
        const { full_name, status, property_type, meter_number, recent_meter_reading } = responseData;
        const clientProfileLink = `./client_profile.php?id=${this.client_id}`;

        this.elements.statusBadge.html(this.badgeElements[status]);
        this.elements.submitEncode.prop('disabled', status === 'inactive');

        this.elements.fullName.text(full_name);
        this.elements.propertyType.text(property_type);
        this.elements.meterNumber.text(meter_number);
        this.elements.clientProfileLink.attr('href', clientProfileLink);
        this.elements.prevReading.val(recent_meter_reading);
        this.handleStatus(status);
    }

    submitData(responseData) {
        const { client_id, property_type, meter_number } = responseData;

        const prevReading = this.elements.prevReadingInput.val();
        const currReading = this.elements.currReadingInput.val();
        const consumption = this.elements.consumptionInput.val().split(" ")[0];

        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "encodeMeterReadingData",
                formData: {
                    clientID: client_id,
                    prevReading: prevReading,
                    currReading: currReading,
                    propertyType: property_type,
                    meterNumber: meter_number,
                    consumption: consumption
                }
            },
            success: data => {
                console.log(data);
                const filters = JSON.parse(localStorage.getItem('#displayClientForBilling-filterKey'));
                const searchTerm = localStorage.getItem('#displayClientForBilling-searchKey');
                this.tableDisplay.fetchTableData(searchTerm, filters);
                this.hideModal();
            }
        });
    }

    encodeCurrentReading(responseData) {
        this.elements.currReadingInput.val("");
        this.elements.encodeForm.off('submit');
        this.elements.encodeForm.on('submit', e => {
            e.preventDefault();
            if (this.elements.currReadingInput.val().trim() !== '') {
                this.submitData(responseData);
            } else {
                console.log('EMPTY');
            }
        });
    }

    hideModal() {
        this.encodeReadingDataModal.css('display', 'none');
    }
}


function encodeReadingData(clientID) {
    const handler = new EncodeHandler(clientID, new DataTableWithPagination("client_data", '#displayClientForBilling'));
}

window.encodeReadingData = encodeReadingData;

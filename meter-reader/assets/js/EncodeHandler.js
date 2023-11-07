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
            prevReading: $('#prev_reading'),
            submitEncode: $('.submit_encode'),
            copyClientID: $('.copy_client_id'),
            currReadingInput: $('#curr_reading'),
            consumptionInput: $('#consumption'),
            prevReadingInput: $('#prev_reading'),
            encodeForm: $('.encode_form')
        };
    }

    bindEvents() {
        this.elements.currReadingInput.on('input', () => {
            const prevReading = this.elements.prevReadingInput.val();
            const currReading = this.elements.currReadingInput.val();

            let cleanedInput = currReading.replace(/[^\d.]/g, '');
            let currReadingVal = parseFloat(cleanedInput);

            if (isNaN(currReadingVal)) {
                this.elements.currReadingInput.val("");
                this.elements.consumptionInput.val("");
                this.elements.submitEncode.prop('disabled', true);
            } else {
                const computeConsumption = parseFloat(currReadingVal) - parseFloat(prevReading);

                let consumption = parseFloat(computeConsumption);
                this.elements.consumptionInput.val(`${consumption} cubic meter`);
                this.elements.submitEncode.prop('disabled', false);
            }
            this.elements.currReadingInput.val(cleanedInput);

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
        this.elements.submitEncode.html('Encode');
        this.encodeReadingDataModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });
        this.elements.currReadingInput.trigger("focus");
    }

    displayLoadingStatus(el, message) {
        let confirmStatus = $('<div role="status">' +
            '<svg aria-hidden="true" class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-100" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">' +
            '<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />' +
            '<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />' +
            '</svg>' +
            '<span class="sr-only">Loading...</span>' +
            `<span>${message}</span>` +
            '</div>');

        el.html(confirmStatus);
    }

    handleStatus(status) {
        this.elements.currReadingInput.prop('disabled', status !== 'active');
    }

    copyClientID = async (client_id) => {
        try {
            await navigator.clipboard.writeText(client_id);
            console.log('Copied to clipboard!');
        } catch (err) {
            console.error('Failed to copy!', err)
        }
    }

    updateUI(responseData) {
        this.elements.currReadingInput.val("");
        console.log(responseData)
        const { client_id, full_name, status, property_type, meter_number, curr_reading } = responseData; //current_reading in the db

        this.elements.statusBadge.html(this.badgeElements[status]);
        this.elements.currReadingInput.prop('disabled', status === 'inactive');

        this.elements.fullName.text(full_name);
        this.elements.propertyType.text(property_type);
        this.elements.meterNumber.text(meter_number);
        this.elements.prevReading.val(curr_reading);
        this.ha //current_reading in the dbndleStatus(status);

        this.elements.fullName.on('mouseover', () => { this.elements.fullName.text(client_id) });
        this.elements.fullName.on('mouseout', () => { this.elements.fullName.text(full_name) });
        this.elements.copyClientID.on('click', this.copyClientID.bind(this, client_id));


    }

    submitData(responseData) {
        const { client_id, property_type, meter_number } = responseData;

        const prevReading = this.elements.prevReadingInput.val();
        const currReading = this.elements.currReadingInput.val();

        this.displayLoadingStatus(this.elements.submitEncode, 'Encoding...');
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
                }
            },
            success: data => {
                console.log(data);
                setTimeout(() => {
                    alert(JSON.parse(data).message)
                    const filters = JSON.parse(localStorage.getItem('#displayClientForReadingEncoding-filterKey'));
                    const searchTerm = localStorage.getItem('#displayClientForReadingEncoding-searchKey');
                    this.tableDisplay.fetchTableData(searchTerm, filters);
                    this.hideModal();
                }, 500)
            }
        });
    }

    validateInput(responseData) {
        const { curr_reading } = responseData; //current_reading in the db

        if (this.elements.currReadingInput.val().trim() === '') {
            return alert('Input field cannot be empty!');
        }
        const prevReading = parseFloat(curr_reading);
        const currReading = parseFloat(this.elements.currReadingInput.val());

        function validateCurrReading(curr, prev) {
            if (isNaN(curr) || curr <= 0) {
                console.log("Current reading should be a positive number.");
                return false;
            }
            if (curr <= prev) {
                console.log("Current reading should be greater than the previous reading.");
                return false;
            }
            return true;
        }

        if (validateCurrReading(currReading, prevReading)) {
            this.submitData(responseData);
        }

    }

    encodeCurrentReading(responseData) {
        this.elements.submitEncode.off('click');
        this.elements.submitEncode.on('click', e => {
            e.preventDefault();
            this.validateInput(responseData);
        });
    }

    hideModal() {
        this.encodeReadingDataModal.css('display', 'none');
    }
}


function encodeReadingData(clientID) {
    const handler = new EncodeHandler(clientID, new DataTableWithPagination("client_data", '#displayClientForReadingEncoding'));
}

window.encodeReadingData = encodeReadingData;

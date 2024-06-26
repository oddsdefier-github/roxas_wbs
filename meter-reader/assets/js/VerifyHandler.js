import { DataTableWithPagination } from './DataTableWithPagination.js';
class VerifyHandler {
    constructor (clientID, tableDisplay) {
        this.client_id = clientID;

        this.initializeElements();
        this.bindEvents();
        this.retrieveData();
        this.showModal();
        this.tableDisplay = tableDisplay;
    }
    initializeElements() {
        this.verifyReadingDataModal = $('#verifyReadingDataModal');
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
            submitEncode: $('.submit_encode'),
            copyClientID: $('.copy_client_id'),
            currReadingInput: $('#curr_reading'),
            consumptionInput: $('#consumption'),
            prevReadingInput: $('#prev_reading'),
            cancelEdit: $('.cancel_edit'),
            encodeForm: $('.encode_form'),
            sendingEmailModal: $("#sendingEmailModal"),
            messageHeader: $(".message-header"),
            messageBody: $(".message-body")
        };

        this.animationElements = {
            sendingAnim: $(".sending-animation"),
            successAnim: $(".success-animation"),
            errorAnim: $(".error-animation")
        }
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
        this.elements.cancelEdit.on('click', () => {
            this.hideModal();
        });
    }

    retrieveData() {
        const self = this;
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data:
            {
                action: "getClientData",
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
        this.elements.submitEncode.html('Edit');
        this.verifyReadingDataModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });
        this.elements.currReadingInput.trigger("focus");
    }
    showSendingEmailModal() {
        this.animationElements.successAnim.hide();
        this.animationElements.errorAnim.hide();
        this.animationElements.sendingAnim.show();
        this.elements.sendingEmailModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });

    }
    hideModal() {
        this.verifyReadingDataModal.css('display', 'none');
    }

    updateUI(responseData) {
        this.elements.currReadingInput.val("");
        console.log(responseData)
        const { client_id, full_name, status, property_type, meter_number, curr_reading, prev_reading } = responseData;

        this.elements.statusBadge.html(this.badgeElements[status]);
        this.elements.currReadingInput.prop('disabled', status === 'inactive');

        this.elements.fullName.text(full_name);
        this.elements.propertyType.text(property_type);
        this.elements.meterNumber.text(meter_number);

        const computeConsumption = parseFloat(curr_reading) - parseFloat(prev_reading);
        let consumption = parseFloat(computeConsumption);
        this.elements.consumptionInput.val(`${consumption} cubic meter`);

        this.elements.prevReadingInput.val(prev_reading);
        this.elements.currReadingInput.val(curr_reading);
        this.handleStatus(status);

        this.elements.fullName.on('mouseover', () => { this.elements.fullName.text(client_id) });
        this.elements.fullName.on('mouseout', () => { this.elements.fullName.text(full_name) });
        this.elements.copyClientID.on('click', this.copyClientID.bind(this, client_id));
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
    validateInput(responseData) {
        const { prev_reading } = responseData;

        if (this.elements.currReadingInput.val().trim() === '') {
            return alert('Input field cannot be empty!');
        }
        const prevReading = parseFloat(prev_reading);
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

    displayTable() {
        const filters = JSON.parse(localStorage.getItem('#displayClientForReadingVerification-filterKey'));
        const searchTerm = localStorage.getItem('#displayClientForReadingVerification-searchKey');
        this.tableDisplay.fetchTableData(searchTerm, filters);
    }
    submitData(responseData) {
        const { client_id, property_type, meter_number, billing_id, billing_month } = responseData;

        const prevReading = this.elements.prevReadingInput.val();
        const currReading = this.elements.currReadingInput.val();

        this.displayLoadingStatus(this.elements.submitEncode, 'Updating...');
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "editReadingData",
                formData: {
                    billingID: billing_id,
                    billingMonth: billing_month,
                    clientID: client_id,
                    prevReading: prevReading,
                    currReading: currReading,
                    propertyType: property_type,
                    meterNumber: meter_number,
                }
            },
            success: data => {
                setTimeout(() => {
                    const responseData = JSON.parse(data);
                    const { status, message } = responseData;
                    alert(message);
                    this.displayTable();
                    this.hideModal();
                }, 100)
            }
        });
    }
    handleSendEmail(clientID) {
        this.elements.messageHeader.text('Sending Email...');
        this.elements.messageBody.text('Please be patient. This may take a minute or more.');
        this.showSendingEmailModal();

        const self = this;
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "sendIndividualBilling",
                clientID: clientID
            },
            success: function (data) {
                console.log(data)
                const response = JSON.parse(data).status;
                const message = JSON.parse(data).message;

                if (data) {
                    if (response === 'error') {
                        self.elements.messageHeader.text('Error.');
                        self.elements.messageBody.text(message);
                        self.animationElements.successAnim.hide();
                        self.animationElements.sendingAnim.hide();
                        self.animationElements.errorAnim.show();

                    } else if (response === 'success') {
                        self.elements.messageHeader.text('Success.');
                        self.elements.messageBody.text(message);
                        self.animationElements.sendingAnim.hide();
                        self.animationElements.errorAnim.hide();
                        self.animationElements.successAnim.show();
                    }
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        })
    }
}


function editReadingData(clientID) {
    const handler = new VerifyHandler(clientID, new DataTableWithPagination("billing_data", '#displayClientForReadingVerification'));
}

function verifyAllBillingData() {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "verifyAllBillingData",
        },
        success: data => {
            console.log(data)
            const responseData = JSON.parse(data);
            const { is_verified, message } = responseData;

            if (is_verified) {
                alert(message);
                $('div[data-billing-verified="false"]').hide();
                $('div[data-billing-verified="true"]').show();
                new DataTableWithPagination("billing_data", '#displayClientForReadingVerification');
            } else {
                alert(message);
                $('div[data-billing-verified="false"]').show();
                $('div[data-billing-verified="true"]').hide();
            }
        }
    })
}

const downloadRecentBill = $("#download_recent_bill");
const generateBillingPDFBtn = $("#generateBillingPDF");
const pdfIcon = $('.pdf');
const lockIcon = $('.lock');


function getLatestBillingLogDataForMonth() {
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "getLatestBillingLogDataForMonth"
        },
        success: function (data) {
            console.log(data)
            handleDownload(data);
        },
        complete: function () {
            setTimeout(getLatestBillingLogDataForMonth, 5000);
        }
    })
}

getLatestBillingLogDataForMonth();

function handleDownload(data) {
    console.log(data)
    if (data && data !== 'null') {
        const { filename, filepath } = JSON.parse(data);
        downloadRecentBill.show();
        downloadRecentBill.attr('href', filepath);
        downloadRecentBill.attr('download', filename);
        generateBillingPDFBtn.attr('title', 'Billing PDF already generated, download instead.')
        generateBillingPDFBtn.prop('disabled', true);
        lockIcon.show();
        pdfIcon.hide();
    } else {
        downloadRecentBill.hide();
        generateBillingPDFBtn.prop('disabled', false);
        generateBillingPDFBtn.attr('title', 'Generated Billing PDF.')
        pdfIcon.show();
        lockIcon.hide();
    }
}

function handleGeneratePDF() {
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "generateAllBilling"
        },
        success: function (data) {
            console.log(data);
            setTimeout(function () {
                const responseData = JSON.parse(data);
                const { filename, filepath } = responseData;
                if (responseData.status === 'success') {
                    downloadPDF(filepath, filename);
                    setTimeout(() => {
                        generateBillingPDFBtn.prop('disabled', true);
                        lockIcon.show();
                        pdfIcon.hide();
                    }, 1000);
                } else {
                    console.error("Error in report generation:", responseData.error);
                }
            }, 100);
        }
    })
}


function downloadPDF(pdfPath, dynamicFilename) {
    var link = document.createElement("a");
    link.href = pdfPath;
    link.download = dynamicFilename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function generateBillingPDF() {
    handleGeneratePDF();
}

window.editReadingData = editReadingData;
window.verifyAllBillingData = verifyAllBillingData;
window.generateBillingPDF = generateBillingPDF;


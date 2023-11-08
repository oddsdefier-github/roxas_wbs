
class BillUIHandler {
    constructor (action = 'sendIndividualBilling') {
        this.action = action;

        this.elements = {
            sendingEmailModal: $("#sendingEmailModal"),
            messageHeader: $(".message-header"),
            messageBody: $(".message-body")
        }
        this.animationElements = {
            sendingAnim: $(".sending-animation"),
            successAnim: $(".success-animation"),
            errorAnim: $(".error-animation")
        }

        this.handleDBRequest(this.action);
        this.bindEvents();
    }

    bindEvents() {

    }
    showModal() {
        this.animationElements.sendingAnim.show();
        this.elements.sendingEmailModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });

    }
    handleModalUI() {

    }

    successHandler() {

    }
    errorHandler() {

    }
    handleDBRequest(action = this.action) {
        const self = this;
        this.showModal();
        let count = 0;
        let animationInterval = setInterval(function () {
            console.log("Waiting for data...");
            count++
            console.log(count)
        }, 1000);
        $.ajax({
            url: "bill_generation.php",
            type: "post",
            data: {
                action: action
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

                        setTimeout(() => {
                            $("#generateBillingPDF").show();
                            alert('Click the generate button to generate billing PDF.');
                        }, 1000)

                        $("#generateBillingPDF").hide();
                    }

                    clearInterval(animationInterval);
                }
                // window.open('./billing-pdf.php')
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        })
    }
}

function sendIndividualBilling() {
    new BillUIHandler('sendIndividualBilling')
}

function generateBillingPDF() {
    window.open('./billing-pdf.php');
}
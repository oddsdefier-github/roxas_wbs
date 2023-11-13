
function checkVerifiedBill() {
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "checkVerifiedBill"
        },
        success: function (data) {
            console.log(data);
            if (data) {
            if (data !== 'null') {
                    updateUI(data);
                }
            }
        }
    })
}

function updateUI(data) {
    const responseData = JSON.parse(data);
    const verifiedBill = responseData.total_verified;
    const totalBill = responseData.total_billing;

    $(".total_verified").text(verifiedBill);
    $(".total_billing").text(totalBill);

    if (responseData.is_match) {
        $("#generateBillingPDF").prop('disabled', false);
        $(".lock").hide();
        $(".pdf").show();
    } else {
        $("#generateBillingPDF").prop('disabled', true);
        $(".lock").show();
        $(".pdf").hide();
    }
}

checkVerifiedBill();

function generateBillingPDF() {
    // window.open('./billing-pdf.php');
    alert('This feature is not yet available.')
}
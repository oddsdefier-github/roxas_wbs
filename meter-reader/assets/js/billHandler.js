const downloadRecentBill = $("#download_recent_bill");
const generateBillingPDFBtn = $("#generateBillingPDF");
const pdfIcon = $('.pdf');
const lockIcon = $('.lock');


function checkVerifiedBill() {
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
            setTimeout(checkVerifiedBill, 5000);
        }
    })
}


checkVerifiedBill();

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
import { DataTableWithPagination } from './DataTableWithPagination.js';
$(document).ready(function () {


    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);


    $('.page_nav').each(function () {
        $(this).find('a').each(function () {
            const linkHref = $(this).attr('href');
            const linkFilename = linkHref.substring(linkHref.lastIndexOf('/') + 1);

            if (linkFilename === filename) {
                $(this).removeClass('inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50').addClass('inline-block font-bold p-4 text-primary-700 bg-primary-100 rounded-t-lg active');
            }
        });
    })


    switch (filename) {
        case 'encode_meter_reading.php':
            $("#clientStatusFilter").show();

            const today = new Date();
            const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

            const todayDate = today.getDate();

            if (today.getDate() === todayDate) {
                $(".main-content").show();
                new DataTableWithPagination("client_data", '#displayClientForReadingEncoding');
            } else {
                $(".main-content").show();
                const daysLeft = lastDayOfMonth.getDate() - today.getDate();
                $(".main-content").html(`Wait for ${daysLeft}days to encode new reading again.</br>Have a nice day!`);
            }

            break;
        case 'verify_meter_reading.php':

            $(".main-content").show();
            new DataTableWithPagination("billing_data", '#displayClientForReadingVerification');

            break;
        case 'bill_meter_reading.php':
            $("#generateBillingPDF").show();
            $("#sendIndividualBilling").show();
            $(".main-content").show();

            new DataTableWithPagination("billing_data_verified", '#displayClientForBillingGeneration');

            break;
        default:
            $("#clientStatusFilter").hide();
            $("#sendIndividualBilling").hide();
            $("#generateBillingPDF").hide();
            break;
    }


});

import { DataTableWithPagination } from './DataTableWithPagination.js';
$(document).ready(function () {


    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    if (filename === 'encode_meter_reading.php') {
        const today = new Date();
        const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

        const todayDate = today.getDate();
        if (today.getDate() === todayDate) {
            $(".main-content").show();
            const clientTable = new DataTableWithPagination("client_data", '#displayClientForReadingEncoding');
        } else {
            $(".main-content").show();
            const daysLeft = lastDayOfMonth.getDate() - today.getDate();
            $(".main-content").html(`Wait for ${daysLeft}days to encode new reading again.</br>Have a nice day!`);
        }

    } else if (filename === 'verify_meter_reading.php') {
        $(".main-content").show();
        const clientTable = new DataTableWithPagination("billing_data", '#displayClientForReadingVerification');


    } else if (filename === 'bill_meter_reading.php') {
        $(".main-content").show();
        const clientTable = new DataTableWithPagination("billing_data_verified", '#displayClientForBillingGeneration');
    }


    $('.page_nav').each(function () {
        $(this).find('a').each(function () {
            const linkHref = $(this).attr('href');
            const linkFilename = linkHref.substring(linkHref.lastIndexOf('/') + 1);

            if (linkFilename === filename) {
                $(this).removeClass('inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50').addClass('inline-block font-bold p-4 text-primary-700 bg-primary-100 rounded-t-lg active');
            }
        });
    })
    filename === 'encode_meter_reading.php' ? $("#clientStatusFilter").show() : $("#clientStatusFilter").hide();

});

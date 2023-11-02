import { DataTableWithPagination } from './DataTableWithPagination.js';
function populateAddressFilter(callback) {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "getAddressData"
        },
        success: function (data) {
            console.log(data)
            callback(data)
        }
    })
}


populateAddressFilter(function (data) {
    const addressData = JSON.parse(data).address;
    console.log(addressData)
    const addressFilter = $("#address_filter");

    addressFilter.empty();
    addressFilter.append(`<p class="font-semibold uppercase py-1 text-xs text-gray-500">Address</p>`);
    addressData.forEach((address) => {

        let filter = $(
            `<li title="Address">
                    <div class="flex items-center p-2 rounded hover:bg-gray-100">
                        <label for="${address.brgy}" class="w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                            <input id="${address.brgy}" type="radio" value="${address.brgy}" data-column="brgy" name="brgy" class="mr-1 w-4 h-4 peer text-yellow-400 bg-gray-100 border-gray-300 focus:ring-transparent" data-load-type="static">
                            <span class="peer-checked:text-yellow-400">${address.brgy}</span>
                        </label>
                    </div>
                </li>`
        );

        addressFilter.append(filter);
    });

})

$(document).ready(function () {
    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    if (filename === 'clients.php') {
        const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable');
        $('input[type="radio"]').each(function () {
            $(this).on('change', function () {
                const column = $(this).attr('data-column');
                const value = $(this).val();

                const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable', { column: column, value: value });
            });
        })
    } else if (filename === 'clients_application_table.php') {
        $('input[type="radio"]').each(function () {
            $(this).on('change', function () {
                const column = $(this).attr('data-column');
                const value = $(this).val();

                const clientTable = new DataTableWithPagination("client_application", '#displayClientApplicationTable', { column: column, value: value });
            });
        })
    }




});

//{ column: "status", value: "Active" }
import { DataTableWithPagination } from './DataTableWithPagination.js';

const clientID = localStorage.getItem('clientID');
console.log(clientID);

new DataTableWithPagination("billing", '#displayBillingTable', [{ column: "cd.client_id", value: `${clientID}` }]);


function retrieveClientData(clientID) {
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "retrieveClientData",
            clientID: clientID
        },
        success: function (clientData) {
            updateUI(clientData);
            console.log(clientData)
        }
    })
}

function updateUI(clientData) {
    const { full_name, full_address } = JSON.parse(clientData).client_data[0];
    $("#subheader-title").text(full_name);
    $("#subheader-title").siblings("h5").text(full_address);
    $("#subheader-title").parent("div").siblings("div").hide();
    const backEl = `<button onclick="window.history.back()" class="flex justify-start items-center gap-2 py-3">
    <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg></span> <span>Back</span></button>`;

    $("#subheader-title").siblings("h5").append(backEl);
}
retrieveClientData(clientID);
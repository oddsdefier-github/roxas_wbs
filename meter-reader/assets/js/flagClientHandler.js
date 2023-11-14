import { DataTableWithPagination } from './DataTableWithPagination.js';


function flagClient(clientID) {
    console.log(clientID);
    $("#flagClientModal").css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });

    retrieveClientData(clientID);
}

window.flagClient = flagClient;

function retrieveClientData(clientID) {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data:
        {
            action: "retrieveClientData",
            clientID: clientID
        },
        success: function (data) {
            console.log(data)
            updateFlagClientModalUI(data)
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + ": " + error);
        }
    });
}


function updateFlagClientModalUI(data) {
    const responseData = JSON.parse(data);
    const { full_name, meter_number, property_type, client_id } = responseData

    const fullNameEl = $(".reported_client_name");
    const clientIDEl = $(".reported_client_id");
    const meterNumberEl = $(".reported_meter_number");
    const propertyTypeEl = $(".reported_property_type");

    fullNameEl.text(full_name);
    clientIDEl.text(client_id);
    meterNumberEl.text(meter_number);
    propertyTypeEl.text(property_type.toUpperCase());

    $("#flagClientModal").attr('data-client-id-hidden', client_id);
    $("#flagClientModal").attr('data-client-meter-number-hidden', meter_number);

}


document.addEventListener('DOMContentLoaded', function () {
    let filesArray = [];
    const fileInput = $("#fileInput");
    const reportDescription = $("#report_description");
    const submitReport = $(".submit_report");
    const fileList = $("#fileList");

    const issueTypeSelect = $("#issue_type")
    const otherSpecifyContainer = $("#other_specify_container");

    const otherSpecifyInput = $("#other_specify");

    otherSpecifyInput.on('input', function () {
        let inputValue = $(this).val();
        inputValue = inputValue.replace(/[^a-zA-Z0-9\s.,!?;:-]/g, '');
        $(this).val(inputValue);
    });

    reportDescription.on('input', function () {
        let inputValue = $(this).val();
        inputValue = inputValue.replace(/[^a-zA-Z0-9\s.,!?;:-]/g, '');
        $(this).val(inputValue);
    });

    issueTypeSelect.on('change', function () {
        const selectedValue = $(this).val();
        if (selectedValue === 'other') {
            otherSpecifyContainer.show();
        } else {
            otherSpecifyContainer.hide();
        }
    });


    submitReport.on('click', function (e) {
        e.preventDefault();
        const clientID = $("#flagClientModal").attr('data-client-id-hidden');
        const meterNumber = $("#flagClientModal").attr('data-client-meter-number-hidden');

        if (filesArray.length > 0 && reportDescription.val().trim() !== '') {
            const formData = new FormData($('.meter_report_form')[0]);

            formData.delete('add_img[]');

            for (let i = 0; i < filesArray.length; i++) {
                formData.append('add_img[]', filesArray[i]);
            }

            formData.append('action', 'submitMeterReport');
            formData.append('meterNumber', meterNumber);
            formData.append('clientID', clientID);
            formData.forEach((value, key) => {
                console.log(key, value);

            });
            $.ajax({
                type: 'POST',
                url: 'database_actions.php',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    console.log(response);
                    successHandler(response);
                    filesArray = [];
                },
                error: function (error) {
                    console.error(error);
                }
            });
        } else {
            alert('Please select files and provide a description.');
        }

    });
    function successHandler(response) {
        const responseData = JSON.parse(response);
        alert(responseData.message)

        fileInput.val('');
        reportDescription.val('');
        fileList.empty();
        $("#flagClientModal").hide();

        new DataTableWithPagination("client_data", '#displayClientForReadingEncoding');
    }

    fileInput.on('change', function () {
        const fileList = $('#fileList');
        const totalFiles = filesArray.length + this.files.length;
        console.log("Total Files: " + totalFiles)

        if (totalFiles > 5) {
            alert('You can only select up to 5 files.');
            this.value = '';
            return;
        }

        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            if (file.size <= 10485760) {
                filesArray.push(file);

                const truncatedFileName = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
                const fileNameWithExtension = truncatedFileName + '.' + file.name.split('.').pop();

                // Create a file element template
                const filesEl = $(`
                    <div class="fileElement flex justify-between items-center p-3 px-4 rounded-lg bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="imagePopup" data-image-url="${URL.createObjectURL(file)}">
                                <img src="${URL.createObjectURL(file)}" alt="Preview" class="h-12 max-w-sm">
                            </div>
                            <div class="text-sm font-medium text-gray-800">
                                ${fileNameWithExtension}
                            </div>
                        </div>
                        <button type="button" class="removeFileButton -mx-1.5 -my-1.5 bg-gray-50 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-6 w-6">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                `);

                fileList.append(filesEl);

                filesEl.find('.removeFileButton').on('click', function () {
                    const fileIndex = $(this).closest('.fileElement').index();
                    filesArray.splice(fileIndex, 1);
                    filesEl.remove();
                    if (filesArray.length === 0) {
                        $("#fileInput").val('')
                    }
                });
            } else {
                alert('File size should be less than or equal to 10MB. File ' + file.name + ' exceeds the limit.');
            }
        }


    });
})
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div id="displayClientDataTable">
    </div>
</div>

<script>
    $(document).ready(function() {
        displayClientTable();
        deleteClientRequest();
        fetchAddressData();

    })

    function displayClientTable(page) {
        $.ajax({
            url: "display_table.php",
            type: 'post',
            data: {
                displaySend: page // Send the page number instead of a boolean
            },
            success: function(data, status) {
                $("#displayClientDataTable").html(data);
            }
        });
    }




    function updateClientDetails(updateId) {
        $('#hidden-data').val(updateId);

        $.post("process_update.php", {
            updateId: updateId
        }, function(data, status) {
            let dataRequest = JSON.parse(data);

            let addressData = dataRequest.addressData;
            let clientData = dataRequest.clientData;

            console.log(addressData)

            $('#update_client_name').val(clientData.client_name);
            $('#update_client_email').val(clientData.email);
            $('#update_property_type').val(clientData.property_type);
            $('#update_client_phone_num').val(clientData.phone_number);

            let selectedAddress = clientData.address
            let selectElement = $('#update_client_address');

            $.each(addressData, function(index, item) {
                let option = $('<option>', {
                    value: item.id,
                    text: item.barangay
                });

                if (item.barangay === selectedAddress) {
                    option.prop('selected', true);
                }

                selectElement.append(option);
            });
        });

        $('#updateClientModal')
            .css({
                'display': 'grid',
                'place-items': 'center',
                'justify-content': 'center',
                'align-items': 'center'
            });


    }



    function deletePopUp(delId) {
        $('#hidden-delId').val(delId);

        $(".delete-client").click(function() {
            $("#deleteClientModal").removeClass("hidden").addClass("flex justify-center items-center");
            $("#deleteClientModal").show();
        });
        $.post("fetch_client_data.php", {
            clientId: delId
        }, function(responseData, status) {
            let clientDetails = JSON.parse(responseData);
            console.log(clientDetails);

            let name = clientDetails.clientDetails.client_name;
            let address = clientDetails.clientDetails.address;
            let email = clientDetails.clientDetails.email;
            let property_type = clientDetails.clientDetails.property_type;

            $(document).ready(function() {
                $("#client-details").html(name);

            })
        });
    }


    function deleteClientRequest() {
        let $deleteClientModal = $('#deleteClientModal');
        let $cancelDelete = $("#cancel-deleteClient");

        function closeModal() {
            $deleteClientModal.hide();
        }

        $(".confirm-delete").click(function() {
            let delId = $('#hidden-delId').val();
            $.ajax({
                url: "delete_client_req.php",
                type: 'post',
                data: {
                    deleteSend: delId,
                },
                success: function(data, status) {

                    closeModal();
                    displayClientTable();

                    $("#delete-alerts-popup").removeClass('hidden')
                    setTimeout(function() {
                        $('#delete-alerts-popup').addClass('hidden');
                    }, 3000);
                },

                error: function(xhr, status, error) {
                    console.error("Ajax Error:", error);
                }
            });


        });

        let $closeDeleteModal = $('#close-deleteClient-modal');

        $closeDeleteModal.click(closeModal);
        $cancelDelete.click(closeModal);
    }


    function fetchAddressData() {
        //Fetch DropDown address
        let fetchAddress = true;
        $.ajax({
            url: "fetch_address_data.php",
            type: "get",
            data: {
                fetchAddress: fetchAddress
            },
            success: function(data, status) {
                let dataRequest = JSON.parse(data)
                let addressData = dataRequest.Address
                let selectElement = $('#add_client_address');

                $.each(addressData, function(index, item) {
                    let option = $('<option>', {
                        value: item.id,
                        text: item.barangay

                    });

                    if (index === 0) {
                        option.prop('selected', true);
                    }
                    selectElement.append(option);
                });
            }
        })
        //Fetch DropDown address
    }

    function addClient() {
        let clientNameAdd = $("#add_client_name").val();
        let addressAdd = $("#add_client_address").find(":selected").text();
        let emailAdd = $("#add_client_email").val();
        let propertyTypeAdd = $("#add_property_type").val();
        let phoneNumAdd = $("#add_client_phone_num").val();

        console.log(addressAdd)

        $("#add_client_address").on('change', function() {
            addressAdd
        });


        $.ajax({
            url: "add_client_req.php",
            type: 'post',
            data: {
                clientAdd: clientNameAdd,
                clientAddressAdd: addressAdd,
                clientEmailAdd: emailAdd,
                clientPropertyTypeAdd: propertyTypeAdd,
                clientPhoneNumAdd: phoneNumAdd
            },
            success: function(data, status) {

                displayClientTable();
                $("#add-client-form").reset()

            },

            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        })

    }

    function updateClient() {
        let updateClientName = $("#update_client_name").val();
        let updateClientAddress = $("#update_client_address").find(":selected").text();
        let updateClientEmail = $("#update_client_email").val();
        let updatePropertyType = $("#update_property_type").val();
        let updateClientPhoneNum = $("#update_client_phone_num").val();
        let updateID = $("#hidden-data").val();


        $("#update_client_address").on('change', function() {
            updateClientAddress
        });


        $("#update-client-form").on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "process_update.php",
                type: 'post',
                data: {
                    updateClientName: updateClientName,
                    updateClientAddress: updateClientAddress,
                    updateClientEmail: updateClientEmail,
                    updatePropertyType: updatePropertyType,
                    updateClientPhoneNum: updateClientPhoneNum,
                    updateID: updateID,
                },
                success: function(data, status) {
                    $('#updateClientModal').hide();
                    displayClientTable();
                    console.log("Updated");
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        });

    }
</script>
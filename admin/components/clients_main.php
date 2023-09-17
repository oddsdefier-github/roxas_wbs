<div class="">
    <div id="displayClientDataTable">
    </div>
</div>

<script>
    const toastSuccess = $("#toast-success");
    const toastDanger = $("#toast-danger");
    const toastSuccessMessage = $("#toast-success-message");
    const tableSearch = $("#table-search");
    const recordsPerPageSelect = $("#recordsPerPage");

    const searchType = $("#search-type");
    const addressDropdown = $("#address-dropdown");
    const searchInput = $("#search-input");
    const clearInput = $("#clear-input");

    $(document).ready(function() {
        displayClientTable();
        deleteClientRequest();
        fetchAddressData();
        addClient();


        addressDropdown.hide();

        searchType.on("change", function() {
            recordsPerPageSelect.show();
            displayClientTable();
            var selectedValue = $(this).val();

            if (selectedValue === "address") {
                addressDropdown.change();
                addressDropdown.show();
                searchInput.hide();
            } else {
                addressDropdown.hide();
                searchInput.show();
            }
        });
    })

    function displayClientTable(page, recordsPerPage = "10", query = "") {
        $.ajax({
            url: "display_client_table.php",
            type: 'post',
            data: {
                displaySend: page,
                query: query,
                recordsPerPage: recordsPerPage,

            },
            success: function(data, status) {
                $("#displayClientDataTable").html(data);
            }
        });
    }

    tableSearch.keyup(function() {
        let query = $(this).val();

        if (query.trim() === "") {
            clearInput.hide();
            $("#search-icon").show();
            recordsPerPageSelect.show();
        } else {
            clearInput.show();
            $("#search-icon").hide();
            recordsPerPageSelect.hide();
        }
        displayClientTable(1, "10", query);
    });

    clearInput.click(function() {
        recordsPerPageSelect.toggle();
        tableSearch.val("");
        clearInput.hide();
        $("#search-icon").show();
        displayClientTable(1, "10", "");
    });

    addressDropdown.change(function() {
        recordsPerPageSelect.hide();
        let query = $(this).find(":selected").text();
        displayClientTable(1, "10", query);
    });


    recordsPerPageSelect.change(function() {
        let selectedRecordsPerPage = $(this).val();
        recordsPerPage = selectedRecordsPerPage;
        displayClientTable(1, recordsPerPage, "");
    });


    function updateClientDetails(updateId) {
        $('#hidden-data').val(updateId);

        $.post("update_client_req.php", {
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

                    toastDanger.removeClass('hidden')
                    setTimeout(function() {
                        toastDanger.addClass('hidden');
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
                $('.add_client_address').each(function() {
                    let selectElement = $(this);

                    selectElement.empty();

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
                });
            }
        })
    }

    function addClient() {
        let clientNameAdd = $("#add_client_name").val();
        let addressAdd = $("#add_client_address").find(":selected").text();
        let emailAdd = $("#add_client_email").val();
        let propertyTypeAdd = $("#add_property_type").val();
        let phoneNumAdd = $("#add_client_phone_num").val();

        function closeModal() {
            $deleteClientModal.hide();
        }

        $("#add_client_address").on('change', function() {
            addressAdd
        });

        $("#add-client-form").on("submit", function(e) {
            e.preventDefault();

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

                    console.log(data)
                    displayClientTable();
                    $("#addClientModal").hide();

                    $("#add-client-form")[0].reset();

                    toastSuccess.removeClass('hidden')
                    toastSuccessMessage.text("Client has been added.")
                    setTimeout(function() {
                        toastSuccess.addClass('hidden');
                    }, 2000);

                },

                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            })
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
                url: "update_client_req.php",
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

                    toastSuccess.removeClass('hidden')
                    setTimeout(function() {
                        toastSuccess.addClass('hidden');
                    }, 1500);

                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        });

    }

    function signOut() {
        $.ajax({
            url: "signout.php",
            type: "post",
            success: function(data, status) {

                console.log(JSON.parse(data))
                console.log("SIGN OUT")

                $('#signoutModal').hide();

                let signOutLoading = $(".signout-loader");

                signOutLoading.css({
                    'display': 'flex',
                    'flex-direction': 'column',
                    'justify-content': 'center',
                    'align-items': 'center'
                })

                signOutLoading.show();
                setTimeout(function() {
                    signOutLoading.hide()
                    window.location.href = "../index.php";
                }, 1000)

            }
        })
    }
</script>
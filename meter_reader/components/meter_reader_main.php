<div>
    <div id="displayMeterTable"></div>
</div>

<script src="../js/jquery.min.js"></script>
<script>
    const recordsPerPageSelect = $("#recordsPerPage");
    const tableSearch = $("#table-search");
    const searchType = $("#search-type");
    const addressDropdown = $("#address-dropdown");
    const searchInput = $("#search-input");
    const clearInput = $("#clear-input");

    function displayMeterTable(page = 1, recordsPerPage = "10", query = "") {
        $.ajax({
            url: "display_meter_table.php",
            type: 'post',
            data: {
                displaySend: page,
                query: query,
                recordsPerPage: recordsPerPage,
            },
            success: function(data, status) {
                $("#displayMeterTable").html(data);
            }
        });
    }

    function fetchAddressData() {
        $.ajax({
            url: "fetch_address_data.php",
            type: "get",
            success: function(data) {
                try {
                    let dataRequest = JSON.parse(data);

                    // Check if "Address" property exists in the JSON response
                    if (dataRequest && dataRequest.Address) {
                        let addressData = dataRequest.Address;

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
                    } else {
                        console.error("Invalid data format received from the server.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON data:", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error making the AJAX request:", error);
            }
        });
    }

    function encodeReadingData() {
        $.ajax({
            url: encode_reading_data.php,
            type: "post",
            success: function(data) {

            }
        })
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
    $(document).ready(function() {
        displayMeterTable();
        // fetchAddressData();

        // addressDropdown.hide();

        // searchType.on("change", function() {
        //     recordsPerPageSelect.show();
        //     displayMeterTable();
        //     var selectedValue = $(this).val();

        //     if (selectedValue === "address") {
        //         addressDropdown.change();
        //         addressDropdown.show();
        //         searchInput.hide();
        //     } else {
        //         addressDropdown.hide();
        //         searchInput.show();
        //     }
        // });
        // tableSearch.keyup(function() {
        //     let query = $(this).val();

        //     if (query.trim() === "") {
        //         clearInput.hide();
        //         $("#search-icon").show();
        //         recordsPerPageSelect.show();
        //     } else {
        //         clearInput.show();
        //         $("#search-icon").hide();
        //         recordsPerPageSelect.hide();
        //     }
        //     displayMeterTable(1, "10", query);
        // });

        // clearInput.click(function() {
        //     recordsPerPageSelect.toggle();
        //     tableSearch.val("");
        //     clearInput.hide();
        //     $("#search-icon").show();
        //     displayMeterTable(1, "10", "");
        // });

        // addressDropdown.change(function() {
        //     recordsPerPageSelect.hide();
        //     let query = $(this).find(":selected").text();
        //     displayMeterTable(1, "10", query);
        // });


        recordsPerPageSelect.change(function() {
            let selectedRecordsPerPage = $(this).val();
            recordsPerPage = selectedRecordsPerPage;
            displayMeterTable(1, recordsPerPage, "");
        });
    })
</script>
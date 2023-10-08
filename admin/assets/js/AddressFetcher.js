const AddressFetcher = {
    fetchAddressData: function () {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "database_actions.php",
                type: "post",
                dataType: "json",
                data: {
                    action: "getAddressData"
                },
                success: function (data) {
                    if (data && data.address) {
                        resolve(data.address);
                    } else {
                        reject("Invalid or missing 'address' data in the response.");
                    }
                },
                error: function (xhr, status, error) {
                    reject("AJAX request failed with status: " + status);
                }
            });
        });
    },

    populateAddressDropdowns: function () {
        this.fetchAddressData()
            .then((addressData) => {
                $('.add_client_address').each(function () {
                    let selectElement = $(this);
                    selectElement.empty();
                    $.each(addressData, function (index, item) {
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
            })
            .catch((error) => {
                console.error(error);
            });
    }
};

AddressFetcher.populateAddressDropdowns();
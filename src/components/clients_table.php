<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <?php include 'table_search.php' ?>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-sm text-gray-700 uppercase bg-gray-100">
            <tr>
                <th>No.</th>
                <th>Client ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Property Type </th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Registration Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        if (mysqli_num_rows($result) > 0) {
            $number = 1;
            while ($rows = mysqli_fetch_assoc($result)) {
                $id = $rows['id'];
                echo "<tr>";
                echo "<td>" . $number . "</td>";
                echo "<td>" . $rows["client_id"] . "</td>";
                echo "<td>" . $rows["client_name"] . "</td>";
                echo "<td>" . $rows["address"] . "</td>";
                echo "<td>" . $rows["property_type"] . "</td>";
                echo "<td>" . $rows["email"] . "</td>";
                echo "<td>" . $rows["phone_number"] . "</td>";
                echo "<td>" . $rows["reg_date"] . "</td>";
                echo "<td>
                    
                        <button onclick=\"updateClientDetails('$id')\" class=\"update hover:stroke-blue-200\"><img src=\"./assets/edit.svg\" alt=\"svg\" /></button>
                        <button class=\"hover:stroke-blue-200\"><img src=\"./assets/Delete.svg\" alt=\"svg\" /></button>
                    </td>";


                echo "</tr>";
                $number++;
            }
        } else {
            echo "<tr><td colspan='8'>No data available.</td></tr>";
        }
        ?>
    </table>
</div>

<script>
    function updateClientDetails(updateId) {
        $('#hidden-data').val(updateId);
        $.post("process_update.php", {
            updateId: updateId
        }, function(data, status) {
            let dataRequest = JSON.parse(data);

            let addressData = dataRequest.addressData;
            let clientData = dataRequest.clientData;


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
</script>
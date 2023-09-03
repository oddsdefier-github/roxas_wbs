<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <?php include 'table_search.php' ?>
    <?php include './components/update_client_modal.php' ?>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-sm text-gray-700 uppercase bg-gray-100">
            <tr>
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
            while ($rows = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $rows["client_id"] . "</td>";
                echo "<td>" . $rows["client_name"] . "</td>";
                echo "<td>" . $rows["address"] . "</td>";
                echo "<td>" . $rows["property_type"] . "</td>";
                echo "<td>" . $rows["email"] . "</td>";
                echo "<td>" . $rows["phone_number"] . "</td>";
                echo "<td>" . $rows["reg_date"] . "</td>";
                echo "<td>
                    
                        <button class=\"hover:stroke-blue-200\"><img src=\"./assets/edit.svg\" alt=\"svg\" /></button>
                        <button class=\"hover:stroke-blue-200\"><img src=\"./assets/Delete.svg\" alt=\"svg\" /></button>
                    </td>";


                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data available.</td></tr>";
        }
        ?>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Function to load client data using Ajax
        function loadClientData() {
            $.ajax({
                url: 'client_data.php', // Replace with the actual URL of your PHP script
                method: 'GET',
                dataType: 'json', // Assuming your PHP script returns JSON data
                success: function(data) {
                    // Clear the existing table rows
                    $('#clientTable tbody').empty();

                    if (data.length > 0) {
                        // Loop through the data and append rows to the table
                        $.each(data, function(index, row) {
                            var newRow = '<tr>' +
                                '<td>' + row.client_id + '</td>' +
                                '<td>' + row.client_name + '</td>' +
                                '<td>' + row.address + '</td>' +
                                '<td>' + row.property_type + '</td>' +
                                '<td>' + row.email + '</td>' +
                                '<td>' + row.phone_number + '</td>' +
                                '<td>' + row.reg_date + '</td>' +
                                '<td>' +
                                '<button class="hover:stroke-blue-200"><img src="./assets/edit.svg" alt="svg" /></button>' +
                                '<button class="hover:stroke-blue-200"><img src="./assets/Delete.svg" alt="svg" /></button>' +
                                '</td>' +
                                '</tr>';
                            $('#clientTable tbody').append(newRow);
                        });
                    } else {
                        // No data available
                        var noDataRow = '<tr><td colspan="8">No data available.</td></tr>';
                        $('#clientTable tbody').append(noDataRow);
                    }
                },
                error: function() {
                    // Handle errors if the Ajax request fails
                    console.error('Failed to load client data.');
                }
            });
        }

        // Call the function to load client data on page load
        loadClientData();
    });
</script>
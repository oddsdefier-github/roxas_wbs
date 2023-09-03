<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    
    <?php include 'table_search.php' ?>
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


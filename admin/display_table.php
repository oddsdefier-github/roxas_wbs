<?php
include './connection/database.php';

if (isset($_POST["displaySend"])) {
    $table = '<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-sm text-gray-700 uppercase bg-gray-100">
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th class="px-6 py-3">No.</th>
            <th class="px-6 py-3">Client ID</th>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Address</th>
            <th class="px-6 py-3">Property Type</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Phone Number</th>
            <th class="px-6 py-3">Registration Date</th>
            <th class="px-6 py-3">Action</th>
        </tr>
    </thead>';
    $sql = "SELECT * FROM clients";
    $result = mysqli_query($conn, $sql);
    $number = 1;
    while ($rows = mysqli_fetch_assoc($result)) {
        $id = $rows['id'];
        $client_id = $rows["client_id"];
        $client_name = $rows["client_name"];
        $client_address = $rows["address"];
        $client_property_type = $rows["property_type"];
        $client_email = $rows["email"];
        $client_phone_num = $rows["phone_number"];
        $client_reg_date = $rows["reg_date"];

        $table .= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-3">' . $number . '</td>
            <td class="px-6 py-3">' . $client_id . '</td>
            <td class="px-6 py-3">' . $client_name . '</td>
            <td class="px-6 py-3">' . $client_address . '</td>
            <td class="px-6 py-3">' . $client_property_type . '</td>
            <td class="px-6 py-3">' . $client_email . '</td>
            <td class="px-6 py-3">' . $client_phone_num . '</td>
            <td class="px-6 py-3">' . $client_reg_date . '</td>
            <td class="flex items-center px-6 py-4 space-x-3">
                <button onclick="updateClientDetails(' . $id . ')" class="update ">
                    <img src="./assets/edit.svg" alt="Edit" />
                </button>
                <button onclick="deletePopUp(' . $id . ')" class="delete-client ">
                    <img src="./assets/Delete.svg" alt="Delete" />
                </button>
            </td>
        </tr>';
        $number++;
    }
    $table .= '</table>';
    echo $table;
}

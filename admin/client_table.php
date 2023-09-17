<?php

$table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
    <thead class="text-xs text-gray-500 uppercase">
        <tr class="bg-slate-100 border-b">
            <th class="px-6 py-4">No.</th>
            <th class="px-6 py-4">Client ID</th>
            <th class="px-6 py-4">Name</th>
            <th class="px-6 py-4">Address</th>
            <th class="px-6 py-4">Property Type</th>
            <th class="px-6 py-4">Email</th>
            <th class="px-6 py-4">Phone Number</th>
            <th class="px-6 py-4">Registration Date</th>
            <th class="px-6 py-4">Action</th>
        </tr>
    </thead>';

$number = ($page - 1) * $recordsPerPage + 1;
while ($rows = mysqli_fetch_assoc($result)) {
    $id = $rows['id'];
    $client_id = $rows["client_id"];
    $client_name = $rows["client_name"];
    $client_address = $rows["address"];
    $client_property_type = $rows["property_type"];
    $client_email = $rows["email"];
    $client_phone_num = $rows["phone_number"];
    $client_reg_date = $rows["reg_date"];


    $stored_timestamp = new DateTime($client_reg_date, new DateTimeZone('Asia/Manila')); // Stored timestamp in Philippines timezone

    $current_time = new DateTime('now'); // Current time in Berlin timezone

    $interval = $current_time->diff($stored_timestamp);

    $elapsed_hours = $interval->h + $interval->days * 24;
    $elapsed_minutes = $interval->i;
    $elapsed_seconds = $interval->s;

    if ($elapsed_hours > 0) {
        $elapsed_time_string = $elapsed_hours . ' hrs ' . $elapsed_minutes . ' mins ago';
    } elseif ($elapsed_minutes > 0) {
        $elapsed_time_string = $elapsed_minutes . ' mins ago';
    } elseif ($elapsed_seconds > 0) {
        $elapsed_time_string = $elapsed_seconds . ' secs ago';
    } else {
        $elapsed_time_string = 'just now';
    }



    $readable_format = $stored_timestamp->format('F j, Y, g:i a');


    $table .= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="px-6 py-3 text-sm">' . $number . '</td>
        <td class="px-6 py-3 text-sm">' . $client_id . '</td>
        <td class="px-6 py-3 text-sm">' . $client_name . '</td>
        <td class="px-6 py-3 text-sm">' . $client_address . '</td>
        <td class="px-6 py-3 text-sm">' . $client_property_type . '</td>
        <td class="px-6 py-3 text-sm">' . $client_email . '</td>
        <td class="px-6 py-3 text-sm">' . $client_phone_num . '</td>
        <td class="px-6 py-3 text-sm text-gray-500 cursor-default">
            <span class="font-medium">
            '  . $readable_format . '
            </span>
        </td>
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

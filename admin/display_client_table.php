<?php
include './database/connection.php';

$recordsPerPage = isset($_POST["recordsPerPage"]) ? intval($_POST["recordsPerPage"]) : 12;

$page = isset($_POST["displaySend"]) ? $_POST["displaySend"] : 1;

$offset = ($page - 1) * $recordsPerPage;


if (isset($_POST["query"]) && !empty($_POST["query"])) {
    $query = $_POST["query"];
    $sql = "SELECT * FROM clients WHERE client_name LIKE '%$query%' OR address LIKE '%$query%' ORDER BY reg_date DESC LIMIT $recordsPerPage OFFSET $offset";
} else {
    $sql = "SELECT * FROM clients ORDER BY reg_date DESC LIMIT $recordsPerPage OFFSET $offset";
}

$result = mysqli_query($conn, $sql);

$totalRecords = mysqli_num_rows(mysqli_query($conn, $sql));
$totalPages = ceil($totalRecords / $recordsPerPage);


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



if ($number === 1) {
    echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
} else {
    echo $table;
    echo '<div class="flex gap-2 flex-col justify-center items-end mt-4 text-xs">';
    echo '<div class="flex gap-2 justify-center mt-2">';


    renderPaginationButton('<', $page, $totalPages);

    for ($i = 1; $i <= $totalPages; $i++) {
        renderPaginationButton($i, $page, $totalPages);
    }

    renderPaginationButton('>', $page, $totalPages);

    echo '</div>';
    echo '</div>';
}



function renderPaginationButton($page, $currentPage, $totalPages)
{
    $activeClass = ($page == $currentPage) ? 'bg-indigo-500 text-white' : 'border border-gray-300 text-gray-600';

    if ($page == '<' && $currentPage > 1) {
        echo '<button class="px-3 py-2 ' . $activeClass . ' rounded" onclick="displayClientTable(' . ($currentPage - 1) . ')"> < </button>';
    } elseif ($page == '>' && $currentPage < $totalPages) {
        echo '<button class="px-3 py-2 ' . $activeClass . ' rounded" onclick="displayClientTable(' . ($currentPage + 1) . ')"> > </button>';
    } else {
        echo '<button class="px-3 py-2 ' . $activeClass . ' rounded" onclick="displayClientTable(' . $page . ')"> ' . $page . ' </button>';
    }
}

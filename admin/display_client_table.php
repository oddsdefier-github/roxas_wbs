<?php

include './database/connection.php';



$page = isset($_POST["displaySend"]) ? $_POST["displaySend"] : 1;


if (isset($_POST["query"]) && !empty($_POST["query"])) {

    $query = $_POST["query"];
    $sql = "SELECT * FROM clients WHERE client_name LIKE '%$query%' OR address LIKE '%$query%' OR client_id LIKE '%$query%' ORDER BY reg_date DESC";

    $count_result = "SELECT * FROM clients WHERE client_name LIKE '%$query%' OR address LIKE '%$query%' OR client_id LIKE '%$query%'";
    $totalRecords = mysqli_num_rows($conn->query($count_result));

    $recordsPerPage = $totalRecords;
    $totalPages = 1;
    $result = $conn->query($sql);
} else {
    $recordsPerPage = isset($_POST["recordsPerPage"]) ? intval($_POST["recordsPerPage"]) : 10;
    $offset = ($page - 1) * $recordsPerPage;
    $sql = "SELECT * FROM clients ORDER BY reg_date DESC LIMIT $recordsPerPage OFFSET $offset";
    $result = $conn->query($sql);

    $sql = "SELECT * from clients";
    $totalRecords = mysqli_num_rows($conn->query($sql));
    $totalPages = ceil($totalRecords / $recordsPerPage);
}


$table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
    <thead class="text-xs text-gray-500 uppercase">
        <tr class="bg-slate-100 border-b">
            <th class="px-6 py-4">No.</th>
            <th class="px-6 py-4">Client ID</th>
            <th class="px-6 py-4">Client Names&nbsp;&nbsp; 
            <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
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


    $table .= '<tr class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="px-6 py-3 text-sm">' . $number . '</td>
        <td class="px-6 py-3 text-sm">' . $client_id . '</td>
        <td class="px-6 py-3 text-sm hover:text-primary-500"><a target="_blank" href="./client_profile.php?client_id=' . $client_id . '">' . $client_name . '</a></td>
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
            <button onclick="updateClient(' . $id . ')" type="button" class="update text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16px" class=" w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            <span class="sr-only">Icon description</span>
            </button>
            <button  onclick="deleteClient(' . $id . ')" type="button" class="delete-client text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16px" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            <span class="sr-only">Icon description</span>
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

    if ($totalPages > 1 && empty($_POST["query"])) {
        echo '<div class="flex gap-2 flex-col justify-center items-end mt-4 text-xs">';
        echo '<div class="flex gap-2 justify-center mt-2">';

        renderPaginationButton('<<', $page, $totalPages);
        renderPaginationButton('<', $page, $totalPages);

        renderPaginationButton('Current', $page, $totalPages);

        renderPaginationButton('>', $page, $totalPages);
        renderPaginationButton('>>', $page, $totalPages);

        echo '</div>';
        echo '</div>';
    }
}

function renderPaginationButton($page, $currentPage, $totalPages)
{
    $recordsPerPage = intval($_POST["recordsPerPage"]);

    if ($page == '<' && $currentPage > 1) {
        echo '<button class="px-3 py-2 border border-gray-300 text-gray-600 rounded" onclick="displayClientTable(' . ($currentPage - 1) . ', ' . $recordsPerPage . ')"> < </button>';
    } elseif ($page == '>' && $currentPage < $totalPages) {
        echo '<button class="px-3 py-2 border border-gray-300 text-gray-600 rounded" onclick="displayClientTable(' . ($currentPage + 1) . ' , ' . $recordsPerPage . ')"> > </button>';
    } elseif ($page == '<<' && $currentPage > 1) {
        echo '<button class="px-3 py-2  border border-gray-300 text-gray-600 rounded" onclick="displayClientTable(1, ' . $recordsPerPage . ')"> << </button>';
    } elseif ($page == '>>' && $currentPage < $totalPages) {
        echo '<button class="px-3 py-2 border border-gray-300 text-gray-600 rounded" onclick="displayClientTable(' . $totalPages . ', ' . $recordsPerPage . ')"> >> </button>';
    } elseif ($page == 'Current') {
        echo '<button class="px-3 py-2 bg-primary-500 text-white rounded font-medium"> ' . $currentPage . ' </button>';
    }
}

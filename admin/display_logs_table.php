<?php
include './database/connection.php';
session_start();


$page = isset($_POST["displaySend"]) ? $_POST["displaySend"] : 1;


if (isset($_POST["filterLogs"]) && !empty($_POST["filterLogs"])) {
    $filterLogs = $_POST["filterLogs"];
    $sql = "SELECT * FROM logs WHERE user_activity LIKE '%$filterLogs%' ORDER BY datetime DESC";

    $count_result = "SELECT * FROM logs WHERE user_activity LIKE '%$filterLogs%'";
    $totalRecords = mysqli_num_rows($conn->query($count_result));

    $recordsPerPage = $totalRecords;
    $totalPages = 1;
    $result = $conn->query($sql);
} else {
    $recordsPerPage = isset($_POST["recordsPerPage"]) ? intval($_POST["recordsPerPage"]) : 10;
    $offset = ($page - 1) * $recordsPerPage;
    $sql = "SELECT * FROM logs ORDER BY datetime DESC LIMIT $recordsPerPage OFFSET $offset";

    $result = $conn->query($sql);

    $sql = "SELECT * FROM logs";
    $totalRecords = mysqli_num_rows($conn->query($sql));
    $totalPages = ceil($totalRecords / $recordsPerPage);
}


$table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
    <thead class="text-xs text-gray-500 uppercase">
    <tr class="bg-slate-100 border-b">
            <th class="px-6 py-4">No.</th> 
            <th class="px-6 py-4">LOG ID</th>
            <th class="px-6 py-4">User</th> 
            <th class="px-6 py-4">Activity&nbsp;&nbsp; 
                <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span> 
            </th>
            <th class="px-6 py-4">Client Names</th> 
            <th class="px-12 py-4">Description</th>
            <th class="px-6 py-4">DateTime</th>
            <th class="px-6 py-4"></th>
        </tr>
    </thead>';

$number = ($page - 1) * $recordsPerPage + 1;

while ($rows = mysqli_fetch_assoc($result)) {
    $log_id = $rows["log_id"];
    $user_role = $rows["user_role"];
    $user_name = $rows["user_name"];
    $user_activity = $rows["user_activity"];
    $client_id = $rows["client_id"];
    $description = $rows["description"];
    $date = $rows["date"];
    $time = $rows["time"];
    $datetime = $rows["datetime"];



    $stored_timestamp = new DateTime($datetime, new DateTimeZone('Asia/Manila')); // Stored timestamp in Philippines timezone
    $current_time = new DateTime('now'); // Current time in Berlin timezone

    $interval = $current_time->diff($stored_timestamp);

    $elapsed_days = $interval->d;
    $elapsed_hours = $interval->h;
    $elapsed_minutes = $interval->i;
    $elapsed_seconds = $interval->s;

    if ($elapsed_days > 0) {
        $elapsed_time_string = $elapsed_days . ' days ago';
    } elseif ($elapsed_hours > 0) {
        $elapsed_time_string = $elapsed_hours . ' hrs ' . $elapsed_minutes . ' mins ago';
    } elseif ($elapsed_minutes > 0) {
        $elapsed_time_string = $elapsed_minutes . ' mins ago';
    } elseif ($elapsed_seconds > 0) {
        $elapsed_time_string = $elapsed_seconds . ' secs ago';
    } else {
        $elapsed_time_string = 'just now';
    }


    $readable_date = date("F j, Y", strtotime($date));
    $readable_time = date("h:i A", strtotime($time));



    $activity_class = "";

    $client_name = "";

    if ($user_activity == "Update") {
        $activity_class .= "bg-green-100 text-green-600 ";

        $sql = "SELECT client_name FROM clients WHERE id = $client_id";
        $client_name_result = $conn->query($sql);

        if ($client_name_result) {
            $row = mysqli_fetch_assoc($client_name_result);

            if ($row && isset($row['client_name'])) {
                $client_name = $row['client_name'];
            } else {
                $client_name = "Client not found or name is missing.";
            }

            mysqli_free_result($client_name_result);
        } else {
            $client_name = "Error: " . mysqli_error($conn);
        }
    } elseif ($user_activity == "Sign in") {
        $activity_class .= "bg-blue-100 text-blue-500 ";
    } elseif ($user_activity == "Sign out") {
        $activity_class .= "bg-yellow-100 text-yellow-500 ";
    } else {
        $activity_class .= "bg-red-100 text-red-500 ";

        $sql = "SELECT client_name FROM clients_archive WHERE id = $client_id";
        $client_name_result = $conn->query($sql);

        if ($client_name_result) {
            $row = mysqli_fetch_assoc($client_name_result);

            if ($row && isset($row['client_name'])) {
                $client_name = $row['client_name'];
            } else {
                $client_name = "Client not found or name is missing.";
            }

            mysqli_free_result($client_name_result);
        } else {
            $client_name = "Error: " . mysqli_error($conn);
        }
    }


    $table .= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

        <td class="px-6 py-3 text-sm">' . $number . '</td>  
        <td class="px-6 py-3 text-sm">' . $log_id . '</td>  
        <td class="px-6 py-3">
            <span class="font-medium text-sm">' . $user_name . '</span> </br>
            <span class="text-xs">' . $user_role . '</span>
        </td>
        <td class="px-6 py-3 text-sm uppercase">
            <div>
                <p class=" ' . $activity_class . '  inline-block px-3 py-2 font-semibold text-xs rounded-md">' . $user_activity . ' </p>
            </div>
        </td>
        <td class="px-6 py-3 text-sm max-w-sm">
            <p class="text-sm">' . $client_name . '</p>
        </td>
        <td class="px-12 py-3 text-sm max-w-md">
            <span class="text-sm">' . $description . '</span>
        </td>
        <td class="px-6 py-3 text-sm text-gray-500">
            <span class="font-medium text-sm">' . $readable_date . '</span> </br>
            <span class="text-xs">' . $readable_time . '</span>
        </td>
        <td class="px-12 py-3">
            <div class="bg-gray-100 text-gray-500 text-xs inline-flex justify-center items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-gray-300">
            <svg class="w-2 h-2 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
            </svg>
            ' . $elapsed_time_string . '
        </div>
        </td>
    </tr>';
    $number++;
}

$table .= '</table>';
if ($number === 1) {
    echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No logs found</div>';
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
        echo '<button class="px-3 py-2 border border-gray-300 text-gray-600 rounded" onclick="displayLogsTable(' . ($currentPage - 1) . ', ' . $recordsPerPage . ')"> < </button>';
    } elseif ($page == '>' && $currentPage < $totalPages) {
        echo '<button class="px-3 py-2 border border-gray-300 text-gray-600 rounded" onclick="displayLogsTable(' . ($currentPage + 1) . ' , ' . $recordsPerPage . ')"> > </button>';
    } elseif ($page == '<<' && $currentPage > 1) {
        echo '<button class="px-3 py-2  border border-gray-300 text-gray-600 rounded" onclick="displayLogsTable(1, ' . $recordsPerPage . ')"> << </button>';
    } elseif ($page == '>>' && $currentPage < $totalPages) {
        echo '<button class="px-3 py-2 border border-gray-300 text-gray-600 rounded" onclick="displayLogsTable(' . $totalPages . ', ' . $recordsPerPage . ')"> >> </button>';
    } elseif ($page == 'Current') {
        echo '<button class="px-3 py-2 bg-primary-500 text-white rounded font-medium"> ' . $currentPage . ' </button>';
    }
}

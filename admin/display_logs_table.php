
<?php
include './database/connection.php';
session_start();

$recordsPerPage = 10;
$page = isset($_POST["displaySend"]) ? $_POST["displaySend"] : 1;

$offset = ($page - 1) * $recordsPerPage;


if (isset($_POST["query"]) && !empty($_POST["query"])) {
    $query = $_POST["query"];
    $sql = "SELECT * FROM logs WHERE user_role LIKE '%$query%' OR user_name LIKE '%$query%' OR user_activity LIKE '%$query%' ORDER BY datetime DESC LIMIT $recordsPerPage OFFSET $offset;";
} else {
    $sql = "SELECT * FROM logs ORDER BY datetime DESC LIMIT $recordsPerPage OFFSET $offset";
}

$result = mysqli_query($conn, $sql);


$sql = "SELECT * FROM logs";
$totalRecords = mysqli_num_rows(mysqli_query($conn, $sql));
$totalPages = ceil($totalRecords / $recordsPerPage);


$table = '<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-sm text-gray-700 uppercase bg-gray-500 py-5">
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th class="px-1 py-3">No.&nbsp;&nbsp; <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span> </th>
            <th class="px-6 py-3">Activity</th>
            <th class="px-6 py-3">User</th>
            <th class="px-6 py-3">Date Time</th>
        </tr>
    </thead>';

$number = ($page - 1) * $recordsPerPage + 1;
while ($rows = mysqli_fetch_assoc($result)) {
    $user_role = $rows["user_role"];
    $user_name = $rows["user_name"];
    $user_activity = $rows["user_activity"];
    $datetime = $rows["datetime"];


    $user_activity = explode(';', $user_activity);

    if (count($user_activity) == 2) {
        $name = trim($user_activity[0]);
        $updatedDetails = trim($user_activity[1]);
    }

    $stored_timestamp = new DateTime($datetime, new DateTimeZone('Asia/Manila')); // Stored timestamp in Philippines timezone

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
        <td class=" py-3 text-sm text-center">' . $number . '</td>
        <td class="p-2">
            <div class="px-6 py-4 bg-gray-100 rounded-b-md hover:bg-gray-200 max-w-sm">
                <p class="font-medium text-sm ">' . $name . ' </p>
                <p class="font-medium text-xs text-gray-400">' . $updatedDetails . ' </p>
                <div class="mt-3 bg-gray-100 text-gray-500 text-xs inline-flex justify-center items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-gray-300">
                    <svg class="w-2 h-2 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                    </svg>
                ' . $elapsed_time_string . '
                </div>
            </div>
        </td>
        <td class="px-6 py-3">
            <span class="font-medium text-sm">' . $user_name . '</span>
        </span>
        </td>

        <td class="px-6 py-3 text-sm text-gray-500 cursor-default">
            <span class="font-medium" id="dropdownBottomButton" data-dropdown-toggle="dropdownBottom" data-dropdown-placement="bottom" class="mr-3 mb-3 md:mb-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            '  . $readable_format . '
            </span>
            <br>
            <div id="dropdownBottom" class="z-10 hidden bg-gray-100  rounded-md shadow-lg ring-1 ring-gray-300 w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownBottomButton">
                    <li class="px-2 p-1">
                    <span class="font-xs">' . $datetime . '</span>
                    </li>
                </ul>
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
    echo '<div class="flex gap-2 flex-col justify-center items-center mt-4 text-sm">';
    echo '<div class="flex gap-2 justify-center mt-2">';


    renderPaginationButton('prev', $page, $totalPages);

    for ($i = 1; $i <= $totalPages; $i++) {
        renderPaginationButton($i, $page, $totalPages);
    }

    renderPaginationButton('next', $page, $totalPages);

    echo '</div>';
    echo '</div>';
}

function renderPaginationButton($page, $currentPage, $totalPages)
{
    $activeClass = ($page == $currentPage) ? 'bg-indigo-500 text-white' : 'bg-gray-300 text-gray-600';

    if ($page == 'prev' && $currentPage > 1) {
        echo '<button class="px-3 py-1 ' . $activeClass . ' rounded" onclick="displayLogsTable(' . ($currentPage - 1) . ')">prev</button>';
    } elseif ($page == 'next' && $currentPage < $totalPages) {
        echo '<button class="px-3 py-1 ' . $activeClass . ' rounded" onclick="displayLogsTable(' . ($currentPage + 1) . ')">next</button>';
    } else {
        echo '<button class="px-3 py-1 ' . $activeClass . ' rounded" onclick="displayLogsTable(' . $page . ')"> ' . $page . ' </button>';
    }
}

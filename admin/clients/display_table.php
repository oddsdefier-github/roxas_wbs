<?php
include './connection/database.php';


$recordsPerPage = 15;
$page = isset($_POST["displaySend"]) ? $_POST["displaySend"] : 1;

$offset = ($page - 1) * $recordsPerPage;


if (isset($_POST["query"]) && !empty($_POST["query"])) {
    $query = $_POST["query"];
    $sql = "SELECT * FROM clients WHERE client_name LIKE '%$query%' OR address LIKE '%$query%' LIMIT $recordsPerPage OFFSET $offset";
} else {
    $sql = "SELECT * FROM clients LIMIT $recordsPerPage OFFSET $offset";
}

$result = mysqli_query($conn, $sql);


$sql = "SELECT * FROM clients";
$totalRecords = mysqli_num_rows(mysqli_query($conn, $sql));
$totalPages = ceil($totalRecords / $recordsPerPage);


$table = '<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-sm text-gray-700 uppercase bg-gray-100">
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th class="px-3 py-3">No.&nbsp;&nbsp; <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span> </th>
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

    $table .= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="px-3 py-3">' . $number . '</td>
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





function renderPaginationButton($page, $currentPage, $totalPages)
{
    $activeClass = ($page == $currentPage) ? 'bg-indigo-500 text-white' : 'bg-gray-300 text-gray-600';

    if ($page == 'prev' && $currentPage > 1) {
        echo '<button class="px-3 py-1 ' . $activeClass . ' rounded" onclick="displayClientTable(' . ($currentPage - 1) . ')">prev</button>';
    } elseif ($page == 'next' && $currentPage < $totalPages) {
        echo '<button class="px-3 py-1 ' . $activeClass . ' rounded" onclick="displayClientTable(' . ($currentPage + 1) . ')">next</button>';
    } else {
        echo '<button class="px-3 py-1 ' . $activeClass . ' rounded" onclick="displayClientTable(' . $page . ')"> ' . $page . ' </button>';
    }
}
echo '<div class="flex gap-2 flex-col justify-center items-center mt-4 text-sm">';
echo '<div class="flex gap-2 justify-center mt-2">';


renderPaginationButton('prev', $page, $totalPages);

for ($i = 1; $i <= $totalPages; $i++) {
    renderPaginationButton($i, $page, $totalPages);
}

renderPaginationButton('next', $page, $totalPages);

echo '</div>';
echo '</div>';

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


$sql = "SELECT * FROM clients";
$totalRecords = mysqli_num_rows(mysqli_query($conn, $sql));
$totalPages = ceil($totalRecords / $recordsPerPage);


include 'client_table.php';


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

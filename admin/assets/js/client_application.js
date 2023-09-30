// Define global variables
let currentPageNumber = 1;
let totalItem = 0;
let lastPageNumber = 0;
let itemPerPage = 10; 

function updatePaginationButtons() {
    const prev = $("#prev");
    const next = $("#next");
    prev.prop("disabled", currentPageNumber <= 1);
    next.prop("disabled", currentPageNumber >= lastPageNumber);
    $('a[aria-current="page"]').text(currentPageNumber);
}


function displayClientApplicationTable() {
    console.log("❓");

    $.ajax({
        url: "database_queries.php",
        type: 'post',
        data: {
            action: "getDataTable",
            dataTableParam: {
                pageNumber: currentPageNumber,
                itemPerPage: itemPerPage
            }
        },
        success: function (data, status) {
            console.log(status);
            $('#displayClientApplicationTable').html(data);

            const start = $('input[data-hidden-name="start"]').val();
            const end = $('input[data-hidden-name="end"]').val();
            $('#start').text(start);
            $('#end').text(end);
        }
    });
}

function handlePageChange(direction) {
    if (direction === "prev" && currentPageNumber > 1) {
        currentPageNumber--;
    } else if (direction === "next" && currentPageNumber < lastPageNumber) {
        currentPageNumber++;
    }
    displayClientApplicationTable();
    updatePaginationButtons();
}


function initializePagination(tableName) {
    $.ajax({
        url: "database_queries.php",
        type: "POST",
        data: {
            action: "getTotalItem",
            tableName: tableName
        },
        success: function (data) {
            console.log(data);
            totalItem = JSON.parse(data).totalItem;
            $('#totalItem').text(totalItem);
            lastPageNumber = Math.ceil(totalItem / itemPerPage);
            updatePaginationButtons();
        }
    });
}


$('select[data-table-utilities="itemPerPage"]').change(function () {
    itemPerPage = $(this).val();
    currentPageNumber = 1; 
    displayClientApplicationTable();
    initializePagination("client_application");
});


$("#prev").on("click", () => handlePageChange("prev"));
$("#next").on("click", () => handlePageChange("next"));


displayClientApplicationTable();
initializePagination("client_application");

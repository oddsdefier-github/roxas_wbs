<div class="">
    <div id="displayLogsDataTable">

    </div>
</div>
<script>
    const logsPerPage = $("#recordsPerPage");
    const filterLogsSelect = $("#filter_logs");
    $(document).ready(function() {
        displayLogsTable();
    });

    function displayLogsTable(page, recordsPerPage = "10", filterLogs = "") {
        $.ajax({
            url: "display_logs_table.php",
            type: 'post',
            data: {
                displaySend: page,
                recordsPerPage: recordsPerPage,
                filterLogs: filterLogs
            },
            success: function(data, status) {
                $("#displayLogsDataTable").html(data);
                console.log("LOGS")
            }
        });
    }

    logsPerPage.change(function() {
        let selectedRecordsPerPage = $(this).val();
        recordsPerPage = selectedRecordsPerPage;
        displayLogsTable(1, recordsPerPage);
    });

    filterLogsSelect.change(function() {
        let selectedFilter = $(this).val();
        displayLogsTable(1, "10", selectedFilter);
    });

    function signOut() {
        $.ajax({
            url: "signout.php",
            type: "post",
            success: function(data, status) {

                console.log(JSON.parse(data))
                console.log("SIGN OUT")

                $('#signoutModal').hide();

                let signOutLoading = $(".signout-loader");

                signOutLoading.css({
                    'display': 'flex',
                    'flex-direction': 'column',
                    'justify-content': 'center',
                    'align-items': 'center'
                })

                signOutLoading.show();
                setTimeout(function() {
                    signOutLoading.hide()
                    window.location.href = "../index.php";
                }, 1500)

            }
        })
    }
</script>
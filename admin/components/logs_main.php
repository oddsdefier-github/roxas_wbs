<div class="">
    <div id="displayLogsDataTable">

    </div>
</div>
<script>
    const recordsPerPageSelect = $("#recordsPerPage");
    const filterLogsSelect = $("#filter_logs");
    $(document).ready(function() {
        displayLogsTable();
    });

    function displayLogsTable(page, recordsPerPage = "10") {
        $.ajax({
            url: "display_logs_table.php",
            type: 'post',
            data: {
                displaySend: page,
                recordsPerPage: recordsPerPage
            },
            success: function(data, status) {
                $("#displayLogsDataTable").html(data);
                console.log("LOGS")
            }
        });
    }

    recordsPerPageSelect.change(function() {
        let selectedRecordsPerPage = $(this).val();
        recordsPerPage = selectedRecordsPerPage;
        displayLogsTable(1, recordsPerPage);
    });

    // filterLogsSelect.change(function() {
    //     let selectedRecordsPerPage = $(this).val();
    //     recordsPerPage = selectedRecordsPerPage;
    //     displayLogsTable(1, recordsPerPage);
    // });

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
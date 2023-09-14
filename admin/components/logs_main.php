<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div id="displayLogsDataTable">

    </div>
</div>
<script>
    let tableSearch = $("#table-search")
    $(document).ready(function() {
        displayLogsTable();
    });

    function displayLogsTable(page, query = "") {
        $.ajax({
            url: "display_logs_table.php",
            type: 'post',
            data: {
                displaySend: page,
                query: query
            },
            success: function(data, status) {
                $("#displayLogsDataTable").html(data);
                console.log("LOGS")
            }
        });
    }
    tableSearch.keyup(function() {
        let query = $(this).val();
        displayLogsTable(1, query);
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
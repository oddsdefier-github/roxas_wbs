<script>
    $(document).ready(function() {
        $('#updateClientModal').hide()
        $('#updateClientButton').click(function() {
            $('#updateClientModal').toggle();
        });
        $('#closeModal').click(function() {
            $('#updateClientModal').hide();
            $('.modal-container').hide();
        });

        // signout-modal
        let $signoutModal = $('#signoutModal');
        let $signoutBtn = $('#signout');
        let $closeModal = $('#close-signout-modal');
        let $cancelSignout = $("#cancel-signout")

        $closeModal.click(function() {
            $signoutModal.toggle();
        })

        $cancelSignout.click(function() {
            $signoutModal.hide();
        })
        $signoutBtn.click(function() {
            $signoutModal.removeClass("hidden").addClass("flex justify-center items-center");
            $signoutModal.show();
        })
    });
</script>
<script src=".../node_modules/jquery/dist/jquery.js"></script>
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

    });
</script>

<div id="imageModal" class="hidden items-center justify-center z-20">

    <div class="modal-content max-w-md mx-auto bg-white p-4 rounded-lg">
        <img id="fullImage" alt="Full Image">
    </div>
</div>
<script src="../node_modules/jquery/dist/jquery.js"></script>
<script>
    $(document).ready(function() {
        var $modal = $('#imageModal');
        var $fullImage = $('#fullImage');
        var $thumbnail = $('#thumbnail');

        $thumbnail.mouseenter(function() {
            var thumbnailSrc = $thumbnail.attr('src');
            $fullImage.attr('src', thumbnailSrc);
            $modal.show();
        });

        $thumbnail.mouseleave(function() {
            $modal.hide();
        });

        $thumbnail.click(function() {
            $modal.hide();
        });
    });
</script>
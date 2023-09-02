<script src="../node_modules/jquery/dist/jquery.js"></script>
<script>
    $(document).ready(function() {
        $("table th").addClass("px-6 py-3");
        $("table td").addClass("px-6 py-3");
        $("td:has(a)").addClass("flex items-center px-6 py-4 space-x-3");
        $("table td a").addClass("font-medium text-blue-600 hover:underline");
        $("table tr").addClass("bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600");
    });
</script>
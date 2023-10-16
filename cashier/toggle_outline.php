<div>
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" class="sr-only peer">
        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Debug</span>
    </label>
</div>
<script>
    $(document).ready(function() {
        const toggle = $('input[type="checkbox"]');
        const debugColors = [
            "#FF0000", // Red
            "#FF4500", // Orange Red
            "#FF6347", // Tomato
            "#FF7F50", // Coral
            "#DC143C", // Crimson
            "#FF8C00", // Dark Orange
            "#FFA500", // Orange
        ];

        const savedState = localStorage.getItem("checkBoxState");
        if (savedState !== null) {
            toggle.prop("checked", JSON.parse(savedState));

            if (toggle.prop("checked")) {
                applyOutline();
            }
        }

        toggle.on("change", function() {
            const isChecked = toggle.prop("checked");

            localStorage.setItem("checkBoxState", isChecked);

            if (isChecked) {
                applyOutline();
            } else {
                removeOutline();
            }
        });

        function applyOutline() {
            const randomColorIndex = Math.floor(Math.random() * debugColors.length);
            const randomColor = debugColors[randomColorIndex];

            $("*").css({
                "outline": `1px solid ${randomColor}`
            });
        }

        function removeOutline() {
            $("*").css({
                "outline": "0"
            });
        }
    });
</script>
<div class="px-10 mb-10">
    <div>
        <?php include './layouts/reports_nav.php' ?>
    </div>
    <div class="flex justify-center items-start" style="height: 48rem; margin-top: 4rem;">
        <div class="max-w-xl">
            <div>
                <h3>Generate Reports</h3>
            </div>
            <div class="flex gap-2 justify-center items-center">
                <p>Category</p>
                <select name="report_category" id="report_category">
                    <option value="application_revenue">Application Revenue</option>
                    <option value="billing_revenue">Billing Revenue</option>
                    <option value="all_revenue">All Revenue</option>
                </select>
            </div>
            <div class="flex gap-2 justify-center items-center">
                <p>Report Range</p>
                <div id="reportrange" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium group text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <span class="ml-2"></span>

                </div>
                <button id="gen_report">Generate</button>
            </div>
        </div>
    </div>
</div>
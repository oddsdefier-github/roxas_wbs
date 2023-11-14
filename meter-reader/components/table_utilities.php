<nav class="table-utilities-container block">
    <div class="flex items-center justify-between">
        <div class="flex gap-3">
            <div id="search-input" class="relative">
                <input type="text" id="table-search" class="block p-2 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for client">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 ">
                    <svg id="search-icon" class="w-5 h-5 pointer-events-none text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                    <svg id="clear-input" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>

        </div>
        <div class="flex justify-center items-center gap-3">


            <div id="verified-counter" class="py-2 px-4 font-medium text-gray-900 focus:outline-none bg-gray-50 rounded-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <div class="flex gap-1 text-xs text-gray-500" title="Total Verified Bill / Total Active Clients">
                    <p class="font-bold">
                        <span class="total_verified">0</span>
                        <span>/</span>
                        <span class="total_active">0</span>
                    </p>
                </div>
            </div>
            <div id="encoded-counter" class="py-2 px-4 font-medium text-gray-900 focus:outline-none bg-gray-50 rounded-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <div class="flex gap-1 text-xs text-gray-500">
                    <p class="font-bold" title="Total Encoded Clients / Total Active Clients">
                        <span class="total_encoded">0</span>
                        <span>/</span>
                        <span class="total_active">0</span>
                    </p>
                </div>
            </div>
            <button id="filterReset" class="py-2 px-4 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button">
                <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </button>


            <button id="generateBillingPDF" onclick="generateBillingPDF()" class="flex justify-center items-center py-2 px-4 font-medium text-gray-600 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" disabled style="display: none;">
                <span class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="lock w-5 h-5 hidden">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="pdf w-5 h-5 hidden" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                        <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4"></path>
                        <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6"></path>
                        <path d="M17 18h2"></path>
                        <path d="M20 15h-3v6"></path>
                        <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z"></path>
                    </svg>
                </span>
                <span class="ml-2 text-sm font-medium">Generate</span>
            </button>

            <!-- <button id="sendIndividualBilling" onclick="sendIndividualBilling()" class="flex py-2 px-4 font-medium text-gray-600 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5"></path>
                    <path d="M3 6l9 6l9 -6"></path>
                    <path d="M15 18h6"></path>
                    <path d="M18 15l3 3l-3 3"></path>
                </svg>
                <span class="ml-2 text-sm font-medium">Send Bill</span>
            </button> -->

            <button id="clientStatusFilter" data-dropdown-toggle="clientStatusFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 group hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="filter_text group-hover:text-primary-700">Status</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="clientStatusFilterDropDown" class="dropdown-container z-10 hidden w-44 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" style="width: 13rem;">
                <ul class="px-3 py-2 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioBgHoverButton">
                    <div class="border-b-2 border-gray-200">
                        <li>
                            <div class="flex justify-between">
                                <p class="font-semibold uppercase py-1 text-xs text-gray-500">Status</p>
                            </div>

                        </li>
                        <li title='Status'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="active" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="active" type="radio" value="Active" data-column="status" name="status" class="mr-1 w-4 h-4 peer text-indigo-600 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-indigo-500">active</span>
                                </label>
                            </div>
                        </li>
                        <li title='Status'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="inactive" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="inactive" type="radio" value="Inactive" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-indigo-500">inactive</span></label>
                            </div>
                        </li>
                    </div>
                    <div class="max-h-40 overflow-y-auto py-2" style="max-height: 20rem;">
                        <?php include './components/address_filter.php' ?>
                    </div>
                </ul>
            </div>

            <div class="text-sm uppercase text-gray-400">
                <select id="item-per-page" data-table-utilities="itemPerPage" name="recordsPerPage" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
        </div>
    </div>
</nav>
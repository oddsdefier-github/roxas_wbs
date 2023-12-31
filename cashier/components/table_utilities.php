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
            <div>
                <select id="address-dropdown" name="add_client_address" class="add_client_address hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                </select>
            </div>
        </div>
        <div class="flex justify-center items-center gap-3">

            <button id="qrBilling" class="flex justify-center items-center py-2 px-4 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                </svg>
                <span class="ml-1 text-sm">Scan</span>
            </button>

            <button id="filterReset" class="py-2 px-4 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button">
                <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </button>

            <button id="clientAppFilter" data-dropdown-toggle="clientAppFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium group text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="filter_text group-hover:text-primary-700">Status</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="clientAppFilterDropDown" class="dropdown-container z-10 hidden w-40 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" style="width: 13rem;">
                <ul class="px-3 py-2 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioBgHoverButton">
                    <div class="border-b-2 border-gray-200 py-2">
                        <li>
                            <p class="font-semibold uppercase py-1 text-xs text-gray-500">Property Type</p>
                        </li>
                        <li title='Property Type'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="residential_ca" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="residential_ca" type="radio" value="Residential" data-column="property_type" name="property_type_ca" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-green-400">residential</span>
                                </label>
                            </div>
                        </li>
                        <li title='Property Type'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="commercial_ca" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="commercial_ca" type="radio" value="Commercial" data-column="property_type" name="property_type_ca" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-green-400">commercial</span>
                                </label>
                            </div>
                        </li>
                    </div>
                    <div class="max-h-40 overflow-y-auto py-2" style="max-height: 20rem;">
                        <?php include './components/address_filter_ca.php' ?>
                    </div>
                </ul>
            </div>

            <button id="billingFilter" data-dropdown-toggle="billingFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium group text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="filter_text group-hover:text-primary-700">Status</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="billingFilterDropDown" class="dropdown-container z-10 hidden w-40 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" style="width: 13rem;">
                <ul class="px-3 py-2 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioBgHoverButton">
                    <div class="border-b-2 border-gray-200 py-2">
                        <li>
                            <p class="font-semibold uppercase py-1 text-xs text-gray-500">Property Type</p>
                        </li>
                        <li title='Property Type'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="residential_b" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="residential_b" type="radio" value="Residential" data-column="cd.property_type" name="cd.property_type_b" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-green-400">residential</span>
                                </label>
                            </div>
                        </li>
                        <li title='Property Type'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="commercial_b" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="commercial_b" type="radio" value="Commercial" data-column="cd.property_type" name="cd.property_type_b" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-green-400">commercial</span>
                                </label>
                            </div>
                        </li>
                    </div>
                    <div class="max-h-40 overflow-y-auto py-2" style="max-height: 20rem;">
                        <?php include './components/address_filter_b.php' ?>
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
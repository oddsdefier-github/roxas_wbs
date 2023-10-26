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
            <button id="clientAppStatusFilter" data-dropdown-toggle="clientAppStatusFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="status-text">Status</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="clientAppStatusFilterDropDown" class="dropdown-container z-10 hidden w-44 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioBgHoverButton">
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <label for="approved" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                <input id="approved" type="radio" value="Approved" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500">
                                Approved</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <label for="confirmed" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                <input id="confirmed" type="radio" value="Confirmed" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500">
                                Confirmed</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <label for="unconfirmed" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                <input id="unconfirmed" type="radio" value="Unconfirmed" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500">
                                Unconfirmed</label>
                        </div>
                    </li>
                </ul>
            </div>

            <button id="clientStatusFilter" data-dropdown-toggle="clientStatusFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="status-text">Status</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="clientStatusFilterDropDown" class="dropdown-container z-10 hidden w-44 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioBgHoverButton">
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <label for="active" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                <input id="active" type="radio" value="Active" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500">
                                Active</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <label for="inactive" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                <input id="inactive" type="radio" value="Inactive" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500">
                                Inactive</label>
                        </div>
                    </li>
                </ul>
            </div>






            <div class="text-sm uppercase text-gray-400">
                <select id="item-per-page" data-table-utilities="itemPerPage" name="recordsPerPage" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
        </div>
    </div>
</nav>
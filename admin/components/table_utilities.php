<nav class="table-utilities-container block">
    <div class="flex items-center justify-between">
        <div>
            <div id="date_range_picker" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium group text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span class="ml-2"></span>

            </div>
        </div>

        <div class="flex justify-center items-center gap-3">

            <button id="filterReset" class="py-2 px-4 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-2 focus:ring-gray-200" type="button" disabled>
                <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </button>

            <div class="flex gap-3">
                <div id="search-input" class="relative">
                    <input type="text" id="table-search" class="block p-2 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600" placeholder="Search for client">
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

            <button id="clientAppFilter" data-dropdown-toggle="clientAppFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium group text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="filter_text group-hover:text-primary-700">Filter</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="clientAppFilterDropDown" class="dropdown-container z-10 hidden w-40 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" style="width: 13rem;">
                <ul class="px-3 py-2 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioBgHoverButton">
                    <div class="border-b-2 border-gray-200 py-2">
                        <li>
                            <p class="font-semibold uppercase py-1 text-xs text-gray-500">Billing Status</p>
                        </li>
                        <li title='Billing Status'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="paid" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="paid" type="radio" value="Paid" data-column="billing_status" name="billing_status" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-green-400">paid</span>
                                </label>
                            </div>
                        </li>
                        <li title='Billing Status'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="unpaid" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="unpaid" type="radio" value="Unpaid" data-column="billing_status" name="billing_status" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-green-400">unpaid</span>
                                </label>
                            </div>
                        </li>
                    </div>
                    <div class="border-b-2 border-gray-200 py-2">
                        <li>
                            <p class="font-semibold uppercase py-1 text-xs text-gray-500">Status</p>
                        </li>
                        <li title='Status'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="approved" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="approved" type="radio" value="Approved" data-column="status" name="status" class="mr-1 w-4 h-4 peer text-indigo-600 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-indigo-500">approved</span>
                                </label>
                            </div>
                        </li>
                        <li title='Status'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="confirmed" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="confirmed" type="radio" value="Confirmed" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-transparent">
                                    <span class="peer-checked:text-indigo-500">confirmed</span></label>
                            </div>
                        </li>

                        <li title='Status'>
                            <div class="flex items-center rounded hover:bg-gray-100">
                                <label for="unconfirmed" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                    <input id="unconfirmed" type="radio" value="Unconfirmed" data-column="status" name="status" class="mr-1 w-4 h-4 peer text-indigo-600 bg-gray-100 border-gray-300 focus:ring-transparent">

                                    <span class="peer-checked:text-indigo-500">unconfirmed</span></label>
                                </label>
                            </div>
                        </li>
                    </div>
                    <div class="max-h-40 overflow-y-auto py-2" style="max-height: 20rem;">
                        <?php include './components/address_filter_ca.php' ?>
                    </div>
                </ul>
            </div>

            <button id="clientFilter" data-dropdown-toggle="clientFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 group hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="filter_text group-hover:text-primary-700">Filter</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="clientFilterDropDown" class="dropdown-container z-10 hidden w-44 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                <ul class="px-3 py-2 space-y-1 text-sm text-gray-700" aria-labelledby="dropdownRadioBgHoverButton">
                    <div class="border-b-2 border-gray-200">
                        <ul>
                            <li>
                                <p class="font-semibold uppercase py-1 text-xs text-gray-500">Reading Status</p>
                            </li>
                            <li title='Reading Status'>
                                <div class="flex items-center rounded hover:bg-gray-100">
                                    <label for="read" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                        <input id="read" type="radio" value="Read" data-column="reading_status" name="reading_status" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                        <span class="peer-checked:text-green-400">read</span>
                                    </label>
                                </div>
                            </li>
                            <li title='Reading Status'>
                                <div class="flex items-center rounded hover:bg-gray-100">
                                    <label for="pending" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                        <input id="pending" type="radio" value="Pending" data-column="reading_status" name="reading_status" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                        <span class="peer-checked:text-green-400">pending</span>
                                    </label>
                                </div>
                            </li>
                            <li title='Reading Status'>
                                <div class="flex items-center rounded hover:bg-gray-100">
                                    <label for="encoded" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                        <input id="encoded" type="radio" value="Encoded" data-column="reading_status" name="reading_status" class="mr-1 w-4 h-4 peer text-green-400 bg-gray-100 border-gray-300 focus:ring-transparent">
                                        <span class="peer-checked:text-green-400">encoded</span>
                                    </label>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="border-b-2 border-gray-200 py-2">
                        <ul>
                            <li>
                                <p class="font-semibold uppercase py-1 text-xs text-gray-500">Status</p>
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
                            <li title='Status'>
                                <div class="flex items-center rounded hover:bg-gray-100">
                                    <label for="under_review" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                        <input id="under_review" type="radio" value="Under_Review" data-column="status" name="status" class="mr-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-transparent">
                                        <span class="peer-checked:text-indigo-500">under_review</span></label>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="py-2 overflow-y-auto" style="max-height: 20.5rem;">
                        <?php include './components/address_filter_c.php' ?>
                    </div>
                </ul>
            </div>
            <button id="transactionFilter" data-dropdown-toggle="transactionFilterDropDown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 group hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                </svg>

                <span class="filter_text group-hover:text-primary-700">Filter</span>
                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>

            <div id="transactionFilterDropDown" class="dropdown-container z-10 hidden w-52 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                <ul class="px-3 py-2 space-y-1 text-sm text-gray-700" aria-labelledby="dropdownRadioBgHoverButton">
                    <div class="">
                        <ul>
                            <li>
                                <p class="font-semibold uppercase py-1 text-xs text-gray-500">Transaction Type</p>
                            </li>
                            <li title='Transaction Type'>
                                <div class="flex items-center rounded hover:bg-gray-100">
                                    <label for="bill_payment" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                        <input id="bill_payment" type="radio" value="bill_payment" data-column="transaction_type" name="transaction_type" class="mr-1 w-4 h-4 peer text-green-500 bg-gray-100 border-gray-300 focus:ring-transparent">
                                        <span class="peer-checked:text-green-500">bill_payment</span>
                                    </label>
                                </div>
                            </li>
                            <li title='Transaction Type'>
                                <div class="flex items-center rounded hover:bg-gray-100">
                                    <label for="application_payment" class="p-2 w-full text-sm font-medium text-gray-600 rounded dark:text-gray-300">
                                        <input id="application_payment" type="radio" value="application_payment" data-column="transaction_type" name="transaction_type" class="mr-1 w-4 h-4 peer text-green-500 bg-gray-100 border-gray-300 focus:ring-transparent">
                                        <span class="peer-checked:text-green-500">application_payment</span>
                                    </label>
                                </div>
                            </li>
                        </ul>

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
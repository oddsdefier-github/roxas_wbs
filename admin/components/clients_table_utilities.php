<div class="block">
    <div class="flex items-center justify-between">
        <div class="flex gap-3">
            <div class="text-sm uppercase text-gray-400">
                <select id="search-type" name="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                    <option value="client_name">Name</option>
                    <option value="address">Address</option>
                </select>
            </div>
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

        <div class="text-sm uppercase text-gray-400">
            <select id="recordsPerPage" name="recordsPerPage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
    </div>
</div>
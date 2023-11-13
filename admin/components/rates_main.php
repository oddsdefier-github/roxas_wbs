<div class="px-10 mb-10">
    <div>
        <?php include './layouts/rates_charges_nav.php' ?>
    </div>
    <div class="mt-0">
        <div class="grid grid-cols-6 gap-5">
            <div class="col-span-2">
                <form id="rates_form">
                    <div class="shadow">
                        <div class="border-b border-gray-900/10 pb-5 mb-5 p-5 px-5">
                            <h2 class="uppercase text-base font-bold leading-7 text-gray-700">Update Rates</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Please be reasonable with the input.</p>
                        </div>
                        <div class="sm:col-span-6 grid sm:grid-cols-6 px-5 pb-5">
                            <div class="sm:col-span-6 grid grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="propertyType" class="block text-sm font-medium leading-6 text-gray-900">Property Type</label>
                                    <div class="mt-2 relative">
                                        <select id="propertyType" name="propertyType" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6">
                                            <option value="Residential">Residential</option>
                                            <option value="Commercial">Commercial</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-6 grid-cols-1 px-5">
                            <div class="sm:col-span-6 grid sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                        Rates
                                        <button data-popover-target="popover-disconnection-fee" data-popover-placement="bottom-end" type="button">
                                            <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Show information</span>
                                        </button>
                                    </label>
                                    <div data-popover id="popover-disconnection-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">What is this Rates mean?</h3>
                                            <p>This is the amount that the client pay in peso <span class="text-indigo-400">per cubic meter</span> of water depends on their property type.</p>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>

                                    <div class="mt-2 relative">
                                        <input data-input-state="error" type="text" name="rates" id="rates" class="validate-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="42.00">
                                    </div>
                                    <div data-validate-input="rates" class="validate-message"></div>

                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-x-6 p-5 px-5">
                            <!-- <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button> -->
                            <button id="submit-application" type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
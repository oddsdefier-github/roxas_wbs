<style>
    .validate-message p {
        margin-top: 5px;
        margin-left: 5px;
        color: #f87171;
        line-height: 1rem;
        font-size: 0.725rem;
    }
</style>
<div class="px-10 mb-10">
    <div>
        <?php include './layouts/rates_charges_nav.php' ?>
    </div>
    <div class="mt-0">
        <div class="grid grid-cols-6 gap-5">
            <div class="col-span-2">
                <form id="application_fee_form">
                    <div class="shadow">
                        <div>
                            <div class="border-b border-gray-900/10 py-5 mb-5 pb-5 px-5">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Application Fees</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Please do not change this too often.</p>
                            </div>
                            <div class="grid sm:grid-cols-6 grid-cols-1 gap-x-6 gap-y-4 pb-5 px-5">
                                <div class="sm:col-span-6 grid sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                            Application Fee
                                            <button data-popover-target="popover-application-fee" data-popover-placement="bottom-end" type="button">
                                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Show information</span>
                                            </button>
                                        </label>
                                        <div data-popover id="popover-application-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">What is this Inspection Fee for?</h3>
                                                <p>Covers the inspection related costs.</p>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>


                                        <div class="mt-2 relative">
                                            <input data-input-state="error" type="text" name="applicationFee" id="applicationFee" class="validate-application-fee-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="50.00">
                                        </div>
                                        <div data-validate-input="applicationFee" class="validate-message"></div>

                                    </div>
                                </div>
                                <div class="sm:col-span-6 grid sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                            Inspection Fee
                                            <button data-popover-target="popover-inspection-fee" data-popover-placement="bottom-end" type="button">
                                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Show information</span>
                                            </button>
                                        </label>
                                        <div data-popover id="popover-inspection-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">What is this Inspection Fee for?</h3>
                                                <p>Covers the administrative processing and setup costs associated with new service requests.</p>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>

                                        <div class="mt-2 relative">
                                            <input data-input-state="error" type="text" name="inspectionFee" id="inspectionFee" class="validate-application-fee-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="250.00">
                                        </div>
                                        <div data-validate-input="inspectionFee" class="validate-message"></div>

                                    </div>
                                </div>
                                <div class="sm:col-span-6 grid sm:grid-cols-6 ">
                                    <div class="sm:col-span-6">
                                        <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                            Registration Fee
                                            <button data-popover-target="popover-registration-fee" data-popover-placement="bottom-end" type="button">
                                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Show information</span>
                                            </button>
                                        </label>
                                        <div data-popover id="popover-registration-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">What is this Registration Fee for?</h3>
                                                <p>Bookkeeping and Setting of new accounts.</p>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>

                                        <div class="mt-2 relative">
                                            <input data-input-state="error" type="text" name="registrationFee" id="registrationFee" class="validate-application-fee-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="100.00">
                                        </div>
                                        <div data-validate-input="registrationFee" class="validate-message"></div>
                                    </div>
                                </div>
                                <div class="sm:col-span-6 grid sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                            Connection Fee
                                            <button data-popover-target="popover-connection-fee" data-popover-placement="bottom-end" type="button">
                                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Show information</span>
                                            </button>
                                        </label>
                                        <div data-popover id="popover-connection-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">What is this Connection Fee for?</h3>
                                                <p>Includes the cost of meter and ball valve.</p>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>

                                        <div class="mt-2 relative">
                                            <input data-input-state="error" type="text" name="connectionFee" id="connectionFee" class="validate-application-fee-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="400.00">
                                        </div>
                                        <div data-validate-input="connectionFee" class="validate-message"></div>
                                    </div>
                                </div>
                                <div class="sm:col-span-6 grid sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                            Installation Fee
                                            <button data-popover-target="popover-installation-fee" data-popover-placement="bottom-end" type="button">
                                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Show information</span>
                                            </button>
                                        </label>
                                        <div data-popover id="popover-installation-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">What is this Installation Fee for?</h3>
                                                <p>Cover the labor for installation of connection.</p>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>

                                        <div class="mt-2 relative">
                                            <input data-input-state="error" type="text" name="installationFee" id="installationFee" class="validate-application-fee-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="4000.00">
                                        </div>
                                        <div data-validate-input="installationFee" class="validate-message"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-x-6 pb-5 px-5">
                            <button id="applicationFeeSubmit" type="submit" class="rounded-md bg-indigo-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Edit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-span-2">
                <form id="penalty_fee_form">
                    <div class="shadow">
                        <div>
                            <div class="border-b border-gray-900/10 pb-5 mb-5 p-5 px-5">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Penalty Fees</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Please do not change this too often.</p>
                            </div>
                            <div class="sm:col-span-6 grid sm:grid-cols-6 pb-5 px-5">
                                <div class="sm:col-span-6">
                                    <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                        Late Payment Fee
                                        <button data-popover-target="popover-late-payment-fee" data-popover-placement="bottom-end" type="button">
                                            <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Show information</span>
                                        </button>
                                    </label>
                                    <div data-popover id="popover-late-payment-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">What is this Late Payment Fee for?</h3>
                                            <p>The fee that the client pay for if they pay late.</p>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>

                                    <div class="mt-2 relative">
                                        <input data-input-state="error" type="text" name="latePaymentFee" id="latePaymentFee" class="validate-penalty-fee-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="250.00">
                                    </div>
                                    <div data-validate-input="latePaymentFee" class="validate-message"></div>


                                </div>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-6 grid-cols-1 gap-x-6 gap-y-4 pb-5 px-5">
                            <div class="sm:col-span-6 grid sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label class="flex items-center text-sm font-medium leading-6 text-gray-600">
                                        Reconnection Fee
                                        <button data-popover-target="popover-reconnection-fee" data-popover-placement="bottom-end" type="button">
                                            <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Show information</span>
                                        </button>
                                    </label>
                                    <div data-popover id="popover-reconnection-fee" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">What is this Reconnection Fee for?</h3>
                                            <p>The amount of what the client pay for if they want to be reconnected.</p>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>


                                    <div class="mt-2 relative">
                                        <input data-input-state="error" type="text" name="reconnectionFee" id="reconnectionFee" class="validate-penalty-fee-input block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="20%">
                                    </div>
                                    <div data-validate-input="reconnectionFee" class="validate-message"></div>

                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-x-6 pb-5 px-5">
                            <!-- <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button> -->
                            <button id="rates_submit" type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Edit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
<style>
    #encodeReadingDataModal {
        z-index: 1;
    }

    #encodeReadingDataModal::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(5px);
        z-index: -1;
    }

    .modal-inner-container {
        width: 30rem;
    }
</style>

<section id="encodeReadingDataModal" class="absolute h-screen w-screen z-50 hidden">
    <div class="modal-inner-container">
        <div class="relative w-full max-h-full">
            <div class="bg-white rounded-lg shadow">
                <button data-button-type="close-modal" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <form class="encode_form p-6">
                    <div class="flex flex-col gap-2 mb-3">
                        <div class="mb-2">
                            <h4 class="client-name text-lg font-semibold flex justify-start items-center gap-2">
                                <span class="full_name font-bold cursor-default text-primary-800">Jeffry James M. Paner</span>
                                <a class="client_profile_link hover:bg-gray-200 rounded-full p-2 cursor-pointer" href="" target="_blank" title="Link to client's profile">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span class="status_badge">
                                    <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>

                                </span>
                            </h4>
                            <h6 class="text-sm text-gray-600"><span class="property_type cursor-default uppercase font-semibold" title="Property Type">Residential</span> • <span class="meter_number cursor-default" title="Meter No.">W-12323</span></h6>
                        </div>
                        <div class="py-4">
                            <div class="pb-4">
                                <label for="consumption" class="mb-2 flex items-center text-sm font-semibold text-indigo-800 uppercase">Consumption
                                    <button data-popover-target="consumption-popover" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg><span class="sr-only">Show information</span>
                                    </button>
                                </label>
                                <div data-popover id="consumption-popover" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                    <div class="p-3 space-y-2">
                                        <h3 class="font-semibold text-gray-800 dark:text-white">Consumption</h3>
                                        <p>"Consumption" refers to the amount of water used by a household, business, or other entity during a specified billing period. Consumption is typically measured in units like gallons, cubic meters, or liters, depending on the jurisdiction. The difference between the current reading and the previous reading on a water meter determines the consumption for that period. </p>
                                        <h3 class="font-semibold text-gray-800 dark:text-white pt-2">Calculation Formula</h3>
                                        <div class="px-2 pb-2">
                                            <code class="text-sm font-mono">
                                                Water Consumption = Current Reading - Previous Reading
                                            </code>
                                        </div>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <input type="text" id="consumption" class="validate-input block w-full p-4 text-sm text-gray-400 border border-gray-300 rounded-lg bg-gray-50 sm:text-md" disabled readonly value="Consumption will be automatically calculated">
                            </div>
                            <div class="mb-4">
                                <label for="large-input" class="mb-2 flex items-center text-sm font-medium text-gray-600">Previous Reading
                                    <button data-popover-target="prev-popover" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg><span class="sr-only">Show information</span>
                                    </button>
                                </label>
                                <div data-popover id="prev-popover" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                    <div class="p-3 space-y-2">
                                        <h3 class="font-semibold text-gray-800 dark:text-white">Current Reading</h3>
                                        <p>"Current reading" typically refers to the most recent measurement taken from a water meter to quantify water usage. This reading is used to calculate the amount owed for the billing period. Accurate current readings are essential for fair billing and help consumers track their water consumption, thereby promoting responsible usage.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <input type="text" id="prev_reading" class="validate-input block w-full p-4 text-gray-600 border border-gray-300 rounded-lg bg-gray-50 sm:text-md" disabled readonly value="98 cubic meter">
                            </div>
                            <!-- CURRENT-READING-INPUT -->
                            <div>
                                <label for="curr-reading" class="mb-2 flex items-center text-sm font-medium text-gray-600 dark:text-white">Current Reading
                                    <button data-popover-target="curr-popover" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg><span class="sr-only">Show information</span>
                                    </button>
                                </label>

                                <div data-popover id="curr-popover" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                    <div class="p-3 space-y-2">
                                        <h3 class="font-semibold text-gray-800 dark:text-white">Previous Reading</h3>
                                        <p>"Previous Reading" refers to the recorded measurement taken before the most recent one, indicating the consumption level of a utility or service at that earlier point in time. It serves as a baseline to compare with the current reading, helping users determine the amount of consumption over a specified period.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                                <input type="text" id="curr_reading" class="validate-input block w-full rounded-lg border-0 p-4 text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-500">
                                <div>
                                    <p class="validate-message"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div id="accordion-collapse" data-accordion="collapse">
                        <h2 id="accordion-collapse-heading-1">
                            <button type="button" class="flex items-center justify-between w-full p-2 py-3 font-medium text-left text-gray-500 border border-gray-200 focus:rounded-b-none-0 hover:bg-gray-100" data-accordion-target="#accordion-collapse-body-1" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                                <span class="text-sm font-bold  flex items-center gap-2">
                                    <span class="inline-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path d="M3.5 2.75a.75.75 0 00-1.5 0v14.5a.75.75 0 001.5 0v-4.392l1.657-.348a6.449 6.449 0 014.271.572 7.948 7.948 0 005.965.524l2.078-.64A.75.75 0 0018 12.25v-8.5a.75.75 0 00-.904-.734l-2.38.501a7.25 7.25 0 01-4.186-.363l-.502-.2a8.75 8.75 0 00-5.053-.439l-1.475.31V2.75z" />
                                        </svg>
                                    </span>
                                    Report an issue?
                                </span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-1" class="hidden bg-gray-100 p-3" aria-labelledby="accordion-collapse-heading-1">

                            <div class="flex flex-col gap-2 py-4">
                                <div class="px-2 mb-2">
                                    <label for="small" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Meter Condition</label>
                                    <select id="small" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected>Choose...</option>
                                        <option value="Slightly Damaged">Slightly Damaged</option>
                                        <option value="Damaged">Damaged</option>
                                        <option value="Not Working">Not Working</option>
                                    </select>
                                </div>
                                <div class="px-2 mb-2">
                                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload proof</label>
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                                </div>
                            </div>

                            <div class="px-3 pb-5 rounded-b-lg">
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-900 dark:text-white">Describe the issue</label>
                                    <textarea id="message" rows="4" class="block text-sm w-full rounded-lg border-0 p-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 placeholder:text-sm" placeholder="Write your message here..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class=" flex justify-end items-center space-x-2 mt-4">
                        <button data-button-type="close-modal" type="button" class="text-gray-700 ring-1 ring-gray-300 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Cancel</button>
                        <button type="submit" class="submit_encode text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-2 focus:outline-none focus:ring-indigo-300 dark:focus:ring-indigo-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Encode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
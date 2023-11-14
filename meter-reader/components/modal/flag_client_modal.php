<style>
    #flagClientModal {
        z-index: 1;
    }

    #flagClientModal::before {
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

<section id="flagClientModal" class="absolute h-screen w-screen z-50 hidden">
    <div class="modal-inner-container">
        <div class="relative w-full max-h-full">
            <div class="bg-white rounded-lg shadow">
                <div class="flex justify-between items-center rounded-t p-5 pb-4 border-b dark:border-gray-600">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                        <div class="flex gap-2 items-center">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M3 2.25a.75.75 0 01.75.75v.54l1.838-.46a9.75 9.75 0 016.725.738l.108.054a8.25 8.25 0 005.58.652l3.109-.732a.75.75 0 01.917.81 47.784 47.784 0 00.005 10.337.75.75 0 01-.574.812l-3.114.733a9.75 9.75 0 01-6.594-.77l-.108-.054a8.25 8.25 0 00-5.69-.625l-2.202.55V21a.75.75 0 01-1.5 0V3A.75.75 0 013 2.25z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <h3>
                                Report Client
                            </h3>
                        </div>
                    </h3>
                    <button type="button" data-button-type="close-modal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="meter_report_form p-6">
                    <div class="flex flex-col gap-2 mb-3">
                        <div class="mb-2">
                            <h4 class="text-lg font-semibold flex items-center gap-2">
                                <span class="reported_client_name font-bold cursor-default text-gray-800">Jeffry James M. Paner</span>
                            </h4>
                            <h4 class="text-lg font-semibold flex items-center gap-2">
                                <span class="reported_client_id text-sm font-semibold cursor-default text-gray-500">Jeffry James M. Paner</span>
                            </h4>

                            <h6 class="text-sm text-gray-500"><span class="reported_property_type cursor-default uppercase font-semibold" title="Property Type">Residential</span> • <span class="reported_meter_number cursor-default" title="Meter No.">W-12323</span></h6>
                        </div>
                        <div class="py-4">
                            <label class="block mb-2 text-sm font-bold text-primary-900" for="issue_type">Select the issue type:</label>
                            <select id="issue_type" name="issue_type" class="block w-full mb-3 text-sm text-primary-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 py-[0.6rem]">
                                <option value="no_reading">No Reading/Display Issue</option>
                                <option value="leak_detection">Leak Detection</option>
                                <option value="physical_damage">Physical Damage</option>
                                <option value="connection_issues">Connection Issues</option>
                                <option value="water_quality_concerns">Water Quality Concerns</option>
                                <option value="inaccessibility">Meter Inaccessibility</option>
                                <option value="suspected_tampering">Suspected Tampering</option>
                                <option value="other">Other (Specify)</option>
                            </select>
                            <div id="other_specify_container" class="hidden">
                                <label class="block mb-2 text-sm font-bold text-primary-900" for="other_specify">Specify Issue:</label>
                                <input class="block w-full mb-3 text-sm text-primary-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" type="text" id="other_specify" name="other_specify">
                            </div>
                            <label class="block mb-2 text-sm font-medium text-primary-900" for="fileInput">
                                <p class="font-bold">Images</p>
                                <p class="text-xs">Upload a maximum 5 images with maximum size of 10mb per image.</p>
                            </label>
                            <input class="block w-full mb-3 text-sm text-primary-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" name="add_img[]" id="fileInput" type="file" multiple accept="image/*">

                            <div id="fileList" class="mb-3">
                            </div>
                            <label for="report_description" class="block mb-2 text-sm font-medium text-primary-900">Description</label>
                            <textarea id="report_description" name="report_description" rows="4" class="block p-2.5 w-full text-sm text-primary-900 bg-primary-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500" placeholder="Write your thoughts here..."></textarea>
                        </div>
                    </div>

                    <div class=" flex justify-end items-center space-x-2 mt-4">
                        <button data-button-type="close-modal" type="button" class="text-gray-700 ring-1 ring-gray-300 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Cancel</button>
                        <button type="submit" class="submit_report text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-2 focus:outline-none focus:ring-indigo-300 dark:focus:ring-indigo-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
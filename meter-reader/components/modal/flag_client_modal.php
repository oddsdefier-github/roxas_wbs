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
                <button data-button-type="close-modal" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <form class="meter_report_form p-6">
                    <div class="flex flex-col gap-2 mb-3">
                        <div class="mb-2">
                            <h4>Flag Client</h4>
                        </div>
                        <div class="py-4">
                            <label class="block mb-2 text-sm font-medium text-primary-900 dark:text-white" for="default_size">Images</label>
                            <input class="block w-full mb-5 text-sm text-primary-900 border border-primary-300 rounded-lg cursor-pointer bg-primary-50" id="default_size" type="file" multiple>

                            <label for="report_description" class="block mb-2 text-sm font-medium text-primary-900 dark:text-white">Description</label>
                            <textarea id="report_description" name="report_description" rows="4" class="block p-2.5 w-full text-sm text-primary-900 bg-primary-50 rounded-lg border border-primary-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-primary-700 dark:border-primary-600 dark:placeholder-primary-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">
                            </textarea>
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
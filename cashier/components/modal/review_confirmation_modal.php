<style>
    #reviewConfirmationModal {
        z-index: 1;
    }

    #reviewConfirmationModal::before {
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
</style>

<section id="reviewConfirmationModal" class="absolute h-screen w-screen z-50 hidden">
    <div>
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative p-4 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-lg font-bold text-primary-800">
                        Application Review Confirmation
                    </h3>
                    <button data-button-type="close-modal" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-5 space-y-4">
                    <p class="text-sm leading-relaxed text-gray-500 text-justify">
                        By clicking <code class="font-bold text-gray-600">Submit</code>, you confirm that all client application information has been carefully reviewed and verified by the admin team. This ensures compliance with our protocols and facilitates a smooth execution of upcoming project milestones. All critical aspects have been checked to mitigate risks and ensure the timely delivery of services.
                    </p>
                    <p class="text-xs leading-relaxed text-gray-500 dark:text-gray-400">
                        Disclaimer: All client identities are kept strictly confidential in accordance with privacy laws and regulations. Submitting this form acknowledges your understanding of our commitment to data security and privacy.
                    </p>

                    <div class="flex items-center">
                        <input id="confirm_review_check" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="link-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">I confirm that I reviewed the <span class="text-blue-600 dark:text-blue-500 hover:underline">clients information</span>.</label>
                    </div>

                </div>


                <div class="flex justify-end items-center p-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-button-type="close-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                    <button id="review_confirm" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" disabled>Confirm</button>
                    <button id="approved_client" type="button" class="text-white bg-green-400 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" disabled>Approve</button>
                </div>
                <!-- <input type="hidden" id="delID-hidden"> -->
            </div>
        </div>
    </div>
</section>
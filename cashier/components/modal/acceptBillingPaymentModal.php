<style>
    #acceptBillingPaymentModal {
        z-index: 1;
    }

    #acceptBillingPaymentModal::before {
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
<section id="acceptBillingPaymentModal" class="absolute h-screen w-screen z-50 hidden" data-container="modal" data-modal-name="add_client">
    <div class=" relative p-4 w-full max-w-2xl h-full md:h-auto rounded-md ">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg dark:bg-gray-800 sm:p-5 shadow-lg">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirm Payment
                </h3>
                <button type="button" data-button-type="close-modal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="#">
                <div class="penalty-fees-desc">
                    <div>Application Fee: </div>
                    <div>Inspection Fee: </div>
                    <div>Registration Fee : </div>
                    <div>Connection Fee: </div>
                    <div>Installation Fee: </div>
                </div>
                <div class="flex items-center justify-end space-x-4">
                    <button id="confirm-billing-payment" type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
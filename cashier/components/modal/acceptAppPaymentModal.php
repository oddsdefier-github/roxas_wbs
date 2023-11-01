<style>
    #acceptAppPaymentModal {
        z-index: 1;
    }

    #acceptAppPaymentModal::before {
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
<section id="acceptAppPaymentModal" class="absolute h-screen w-screen z-50 hidden" data-container="modal" data-modal-name="add_client">
    <div class=" relative p-4 w-[36.18rem] max-w-[618px] h-full md:h-auto rounded-md">
        <!-- Modal content -->
        <div class="relative p-5 bg-white rounded-lg shadow-lg">
            <!-- Modal header -->
            <div class="flex justify-between items-center rounded-t pb-4 border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                    <div class="flex gap-2 items-center">
                        <span>
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" class="fill-gray-800 h-5 w-5">
                                <path d="M39.64 40.83L33.87 56.7a1.99 1.99 0 0 1-3.74 0l-5.77-15.87a2.02 2.02 0 0 0-1.2-1.2L7.3 33.88a1.99 1.99 0 0 1 0-3.74l15.87-5.77a2.02 2.02 0 0 0 1.2-1.2L30.12 7.3a1.99 1.99 0 0 1 3.74 0l5.77 15.87a2.02 2.02 0 0 0 1.2 1.2l15.86 5.76a1.99 1.99 0 0 1 0 3.74l-15.87 5.77a2.02 2.02 0 0 0-1.2 1.2z"></path>
                            </svg>
                        </span>
                        <h3>
                            Payment Confirmation
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
            <!-- Modal body -->
            <form action="#" class="">
                <div class="py-5 rounded-md">
                    <div class="w-full grid place-items-center pointer-events-none">
                        <img class="w-48 h-48" src="./assets/payment.svg" alt="Payment Illustration">
                    </div>
                </div>
                <div class="application-fees-desc py-3 flex flex-col gap-2">
                    <div class="flex justify-between w-full py-3 px-2 border border-gray-200 rounded shadow hover:bg-gray-100">
                        <p class="font-medium text-gray-600">Application Fee</p>
                        <p class="application-fee font-bold text-gray-700 "></p>
                    </div>
                    <div class="flex justify-between w-full py-3 px-2 border border-gray-200 rounded shadow hover:bg-gray-100">
                        <p class="font-medium text-gray-600">Inspection Fee </p>
                        <p class="inspection-fee font-bold text-gray-700 "></p>
                    </div>
                    <div class="flex justify-between w-full py-3 px-2 border border-gray-200 rounded shadow hover:bg-gray-100">
                        <p class="font-medium text-gray-600">Registration Fee </p>
                        <p class="registration-fee font-bold text-gray-700 "></p>
                    </div>
                    <div class="flex justify-between w-full py-3 px-2 border border-gray-200 rounded shadow hover:bg-gray-100">
                        <p class="font-medium text-gray-600">Connection Fee</p>
                        <p class="connection-fee font-bold text-gray-700 "></p>
                    </div>
                    <div class="flex justify-between w-full py-3 px-2 border border-gray-200 rounded shadow hover:bg-gray-100">
                        <p class="font-medium text-gray-600">Installation Fee </p>
                        <p class="installation-fee font-bold text-gray-700"></p>
                    </div>
                </div>
                <div class="flex justify-between w-full py-3 px-2 text-lg">
                    <p class="font-bold text-gray-600">Total</p>
                    <p class="total-fee font-bold text-gray-700"></p>
                </div>
                <div class="py-3 flex flex-col justify-center">
                    <div class="">
                        <label for="amount-paid" class="block mb-2 text-right text-sm font-medium text-gray-500">*Amount paid by the applicant</label>
                        <input type="text" name="amount-paid" id="amount-paid" class="block w-full py-3 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-gray-500 focus:border-gray-500" dir="rtl" mode="numeric" pattern="[0-9]+">
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-4 py-3">
                    <button data-button-type="close-modal" type="button" class="text-gray-500 bg-gray-50 hover:bg-gray-100 focus:ring-3 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">No, cancel</button>
                    <button id="confirm-app-payment" type="submit" class="text-white bg-gray-800 hover:bg-gray-600 focus:ring-3 focus:outline-none focus:ring-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<style>
    #qrBillPaymentModal {
        z-index: 1;
    }

    #qrBillPaymentModal::before {
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
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qr-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    #reader {
        border-radius: 3px;
        padding: 10px !important;
    }

    #reader__scan_region {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    #html5-qrcode-button-camera-permission {
        padding: 5px 5px;
        background-color: #e0e7ff;
        border-radius: 5px;
    }

    #html5-qrcode-anchor-scan-type-change {
        display: none !important;
    }

    #html5-qrcode-button-camera-start {
        margin-top: 10px;
        padding: 7px 15px;
        background-color: #e0e7ff;
        border-radius: 5px;
        font-size: 0.75rem;
        line-height: 1rem;
    }

    #html5-qrcode-button-camera-start:hover {
        background-color: #a5b4fc;
    }

    #html5-qrcode-select-camera {
        width: 250px !important;
        border-color: #e0e7ff !important;
        border-radius: 10px !important;
    }

    #html5-qrcode-button-camera-stop {
        margin-top: 10px;
        padding: 7px 15px;
        background-color: #f87171;
        border-radius: 5px;
        font-size: 0.75rem;
        line-height: 1rem;
    }
</style>

<section id="qrBillPaymentModal" class="absolute h-screen w-screen z-50 hidden">
    <div class="modal-inner-container">
        <div class="relative w-full max-h-full">
            <div class="bg-white rounded-lg shadow p-5 text-xs" style="width: 350px">
                <!-- <button data-button-type="close-modal" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button> -->
                <div class="qr-container p-4 py-5">
                    <div style="width: 300px" id="reader"></div>
                </div>
                <div class=" flex justify-end items-center space-x-2">
                    <button data-button-type="close-modal" type="button" class="text-gray-700 ring-1 ring-gray-300 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Close</button>
                </div>
            </div>
        </div>
</section>
<style>
    #clientProfileModal {
        z-index: 1;
    }

    #clientProfileModal::before {
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

<section id="clientProfileModal" class="absolute h-screen w-screen z-50 hidden">
    <div>
        <div class="relative max-h-full">
            <div class="w-[45rem] md:w-[65rem] lg:w-[75rem] relative p-5 bg-white rounded-lg shadow">
                <button data-button-type="close-modal" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div>
                    <span class="content"></span>
                </div>
            </div>
        </div>
    </div>
</section>
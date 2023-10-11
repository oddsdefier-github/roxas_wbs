<style>
    #updateClientModal {
        z-index: 1;
    }

    #updateClientModal::before {
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
<section id="updateClientModal" class="absolute h-screen w-screen z-50 hidden">
    <div class=" relative p-4 w-full max-w-2xl h-full md:h-auto rounded-md ">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-b-lg dark:bg-gray-800 sm:p-5 shadow-lg border-t-4 border-blue-300">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Update client
                </h3>
                <button data-button-type="close-modal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="#" id="update-client-form">
                <div class="grid gap-4 mb-5 sm:grid-cols-2">
                    <div>
                        <label for="update_client_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name </label>
                        <input type="text" name="update_client_name" id="update_client_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ex. Juan Dela Cruz">
                    </div>
                    <div>
                        <label for="update_client_address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <select id="update_client_address" name="update_client_address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </select>
                    </div>


                    <div>
                        <label for="update_client_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" value="juandelacruz@email.com" name="update_client_email" id="update_client_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="juandelacruz@email.com">
                    </div>
                    <div>
                        <label for="update_property_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Property Type</label>
                        <select id="update_property_type" name="update_property_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected>Commercial</option>
                            <option value="Residential">Residential</option>
                        </select>
                    </div>
                    <div>
                        <label for="update_client_phone_num" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone No.</label>
                        <input type="tel" value="09123456789" name="update_client_phone_num" id="update_client_phone_num" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="09123456789">
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="confirmUpdateClient()" id="confirm-client-update" type="submit" class="text-white bg-primary-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Save changes
                    </button>
                    <button data-button-type="close-modal" type="button" class="text-red-500 bg-white hover:bg-red-100 focus:ring-4 focus:outline-none focus:ring-red-200 rounded-lg border border-red-300 text-sm font-medium px-5 py-2.5 hover:text-red-900 focus:z-10 dark:bg-red-700 dark:text-red-300 dark:border-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-600"> Cancel</button>

                    <input type="hidden" name="hidden-data" id="hidden-data">
                </div>
            </form>
        </div>
    </div>
</section>
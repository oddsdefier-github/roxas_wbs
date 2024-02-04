<style>
    .validate-message p {
        margin-top: 5px;
        margin-left: 5px;
        color: #f87171;
        line-height: 1rem;
        font-size: 0.725rem;
    }
</style>
<div class="">
    <form id="userProfileForm">
        <input id="user_id_hidden" type="hidden" value="<?php echo $_SESSION['user_id']; ?>">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="border-b border-gray-900/10 py-3">
                    <h2 class="name-title inline-flex text-base font-semibold leading-7 text-gray-900">User Information </h2>
                    <span class="status_badge ml-2"></span>
                    <p class="address-subtitle mt-1 text-sm leading-6 text-gray-600">Use a valid email where you can receive mail.</p>
                </div>
                <div class="mt-5 grid sm:grid-cols-6 grid-cols-1 gap-x-6 gap-y-8 ">
                    <div class="sm:col-span-6 grid grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="designation" class="select-none block text-sm font-medium leading-6 text-gray-900">Designation</label>
                            <div class="mt-2 relative">
                                <select id="designation" name="designation" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6" readonly disabled>
                                    <option value="Admin">Admin</option>
                                    <option value="Meter Reader">Meter Reader</option>
                                    <option value="Cashier">Cashier</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="sm:col-span-6 grid sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="userId" class="select-none block text-sm font-medium leading-6 text-gray-900">User ID</label>
                            <div class="mt-2 relative">
                                <input data-input-state="error" type="text" name="userId" id="userId" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" readonly disabled>
                            </div>
                            <div data-validate-input="userId" class="validate-message"></div>
                        </div>
                    </div>
                    <div class="sm:col-span-6 grid sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="fullName" class="select-none block text-sm font-medium leading-6 text-gray-900">Name</label>
                            <div class="mt-2 relative">
                                <input data-input-state="error" type="text" name="fullName" id="fullName" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                            <div data-validate-input="fullName" class="validate-message"></div>
                        </div>
                    </div>
                    <div class="sm:col-span-6 grid sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="email" class="select-none block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2 relative">
                                <input data-input-state="error" type="text" name="email" id="email" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                            <div data-validate-input="email" class="validate-message"></div>
                        </div>
                    </div>

                    <div class="sm:col-span-6 grid sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="password" class="select-none block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2 relative">
                                <input data-input-state="error" type="text" name="password" id="password" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="********">

                            </div>
                            <div data-validate-input="password" class="validate-message"></div>
                        </div>
                    </div>
                    <div class="sm:col-span-6 grid sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="confirmPassword" class="select-none block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                            <div class="mt-2 relative">
                                <input data-input-state="error" type="text" name="confirmPassword" id="confirmPassword" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="********">
                            </div>
                            <div data-validate-input="confirmPassword" class="validate-message"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button id="back" onclick="window.history.back()" type="button" class="text-gray-500 bg-gray-50 hover:bg-gray-100 focus:ring-3 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                Back
            </button>

            <button type="submit" class="flex gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">

                <div role="status" class="btn-status-spinner hidden">
                    <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                <span class="submit-update-text">Update</span>
            </button>
        </div>
    </form>
</div>
<script src="./assets/libs/jquery/dist/jquery.min.js"></script>
<script src="./assets/js/userProfileUpdate.js"></script>
<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "Invalid or missing id parameter.";
}
?>
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
    <input type="hidden" id="review-id-hidden" value="<?php echo $id ?>">
    <form class="review-form">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="border-b border-gray-900/10 py-3">
                    <h2 class="name-title text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                    <p class="address-subtitle mt-1 text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6 grid sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="meter-number" class="block text-sm font-medium leading-6 text-gray-900">Meter No.</label>
                            <div class="mt-2 relative">
                                <input data-input-state="error" type="text" name="meterNumber" id="meter-number" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">

                            </div>
                            <div data-validate-input="meterNumber" class="validate-message"></div>
                        </div>
                    </div>


                    <div class="sm:col-span-2">
                        <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                        <div class="mt-2 relative">
                            <input data-input-state="error" type="text" name="firstName" id="first-name" autocomplete="firstName" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                        </div>
                        <div data-validate-input="firstName" class="validate-message"></div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="middle-name" class="block text-sm font-medium leading-6 text-gray-900">Middle name</label>
                        <div class="mt-2 relative">
                            <input data-input-state="error" type="text" name="middleName" id="middle-name" autocomplete="family-name" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">

                        </div>
                        <div data-validate-input="middleName" class="validate-message"></div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
                        <div class="mt-2 relative">
                            <input data-input-state="error" type="text" name="lastName" id="last-name" autocomplete="family-name" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">

                        </div>
                        <div data-validate-input="lastName" class="validate-message"></div>
                    </div>

                    <div class="sm:col-span-1">
                        <label for="age" class="block text-sm font-medium leading-6 text-gray-900">Age</label>
                        <div class="mt-2 relative">
                            <input data-input-state="error" id="age" name="age" type="text" inputmode="numeric" pattern="[0-9]*" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                        </div>
                        <div data-validate-input="age" class="validate-message"></div>
                    </div>
                    <div class="sm:col-span-1">
                        <label for="gender" class="block text-sm font-medium leading-6 text-gray-900">Gender</label>
                        <div class="mt-2 relative">
                            <select id="gender" name="gender" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="phone_number" class="block text-sm font-medium leading-6 text-gray-900">Contact Number</label>
                        <div class="mt-2 relative">
                            <input data-input-state="error" id="phone_number" name="phoneNumber" type="text" inputmode="numeric" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                        </div>
                        <div data-validate-input="phoneNumber" class="validate-message"></div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                        <div class="mt-2 relative">
                            <input data-input-state="error" id="email" name="email" type="email" autocomplete="email" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                        </div>
                        <div data-validate-input="email" class="validate-message"></div>
                    </div>



                    <div class="sm:col-span-4">
                        <label for="propertyType" class="block text-sm font-medium leading-6 text-gray-900">Property Type</label>
                        <div class="mt-2 relative">
                            <select id="propertyType" name="propertyType" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6">
                                <option value="Residential">Residential</option>
                                <option value="Commercial">Commercial</option>
                            </select>
                        </div>
                    </div>


                    <div class="sm:col-span-6">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                        <div class="mt-2 relative">
                            <input id="country" name="country" type="text" autocomplete="country-name" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300
                            focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6" value="Philippines" readonly disabled>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
                        <div class="mt-2 relative">
                            <input data-input-state="error" type="text" name="streetAddress" id="street-address" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">

                        </div>
                        <div data-validate-input="streetAddress" class="validate-message"></div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="brgy" class="block text-sm font-medium leading-6 text-gray-900">Barangay</label>
                        <div class="mt-2 relative">
                            <select id="brgy" name="brgy" class="applicant-address block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </select>
                        </div>
                    </div>


                    <div class="sm:col-span-2">
                        <label for="municipality" class="block text-sm font-medium leading-6 text-gray-900">Municipality</label>
                        <div class="mt-2 relative">
                            <input type="text" name="municipality" id="municipality" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" value="Roxas" readonly disabled>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="province" class="block text-sm font-medium leading-6 text-gray-900">Province</label>
                        <div class="mt-2 relative">
                            <input type="text" name="province" id="province" autocomplete="province" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" value="Oriental Mindoro" readonly disabled>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="region" class="block text-sm font-medium leading-6 text-gray-900">Region</label>
                        <div class="mt-2 relative">
                            <input type="text" name="region" id="region" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" value="REGION IV-B (MIMAROPA)" readonly disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Requirements</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Present a valid documents to verify the identity.</p>

                <div class="mt-10 space-y-10">
                    <fieldset>
                        <legend class="text-base font-semibold leading-6 text-gray-900">Documents</legend>
                        <div class="mt-6 space-y-6">
                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input id="validId" name="validId" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="validId" class="font-medium text-gray-900"><span class="font-bold text-primary-600">Valid ID</span> <br>
                                        <p class="text-gray-500">Presented a valid.</p>
                                    </label>
                                </div>
                            </div>

                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input id="deedOfSale" name="deedOfSale" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="deedOfSale" class="font-medium text-gray-900"><span class="font-bold text-primary-600"> Deed of Sale</span> <br>
                                        <p class="text-gray-500">If land title is not yet transferred to the current.</p>
                                    </label>
                                </div>
                            </div>
                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input id="affidavit" name="affidavit" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="affidavit" class="font-medium text-gray-900"><span class="font-bold text-primary-600">Affidavit of undertaking (when applicable)</span> <br>
                                        <p class="text-gray-500">Presented a Affidavit of undertaking.</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-10 space-y-10">
                    <fieldset>
                        <legend class="text-base font-semibold leading-6 text-gray-900">Pre-Installation Charges</legend>
                        <div class="mt-6 space-y-6">
                            <div class="relative grid grid-rows-5 gap-4 w-1/4">
                                <div class="">
                                    <input type="checkbox" id="application-fee" name="application-fee" value="" class="hidden peer">
                                    <label for="application-fee" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-primary-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="flex gap-2">
                                                <h5 class="font-bold text-primary-600 text-xl">50 PHP</h5>
                                            </div>
                                            <div class="w-full text-lg font-bold text-gray-500">Application Fee</div>
                                            <div class="w-full text-sm">Covers the inspection related costs.</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="">
                                    <input type="checkbox" id="inspection-fee" name="inspection-fee" value="" class="hidden peer">
                                    <label for="inspection-fee" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-primary-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-500 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="flex gap-2">
                                                <h5 class="font-bold text-primary-600 text-xl">250 PHP</h5>
                                            </div>
                                            <div class="w-full text-lg font-bold text-gray-500">Inspection Fee</div>
                                            <div class="w-full text-sm">Covers the administrative processing and setup costs associated with new service requests.</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="">
                                    <input type="checkbox" id="registration-fee" name="registration-fee" value="" class="hidden peer">
                                    <label for="registration-fee" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-primary-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="flex gap-2">
                                                <h5 class="font-bold text-primary-600 text-xl">100 PHP</h5>
                                            </div>
                                            <div class="w-full text-lg font-bold text-gray-500">Registration Fee</div>
                                            <div class="w-full text-sm">Bookkeeping and Setting of new accounts.</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="">
                                    <input type="checkbox" id="connection-fee" name="connection-fee" value="" class="hidden peer">
                                    <label for="connection-fee" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-primary-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-500 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="flex gap-2">
                                                <h5 class="font-bold text-primary-600 text-xl">4100 PHP</h5>
                                            </div>
                                            <div class="w-full text-lg font-bold text-gray-500">Connection Fee</div>
                                            <div class="w-full text-sm">Includes the cost of meter and ball valve.</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="">
                                    <input type="checkbox" id="installation-fee" name="installation-fee" value="" class="hidden peer">
                                    <label for="installation-fee" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-primary-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-500 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="flex gap-2">
                                                <h5 class="font-bold text-primary-600 text-xl">400 PHP</h5>
                                            </div>
                                            <div class="w-full text-lg font-bold text-gray-500">Installation Fee</div>
                                            <div class="w-full text-sm">Dirt or crossing connection</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Reject</button>
            <button id="review-submit" type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" disabled>
                Approve
            </button>
        </div>
    </form>
</div>
<script src="./assets/js/application_review_main.js"></script>
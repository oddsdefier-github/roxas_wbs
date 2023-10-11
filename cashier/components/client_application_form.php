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
    <form id="application_form">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="border-b border-gray-900/10 py-3">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>
                </div>


                <div class="mt-10 grid sm:grid-cols-6 grid-cols-1 gap-x-6 gap-y-8 ">
                    <div class="sm:col-span-6 grid sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="meter-number" class="block text-sm font-medium leading-6 text-gray-900">Meter No.</label>
                            <div class="mt-2 relative">
                                <input data-input-state="error" type="text" name="meterNumber" id="meter-number" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="W-">
                            </div>
                            <div data-validate-input="meterNumber" class="validate-message"></div>
                        </div>
                    </div>
                    <div class="sm:col-span-6 grid grid-cols-6">
                        <div class="sm:col-span-1">
                            <label for="propertyType" class="block text-sm font-medium leading-6 text-gray-900">Property Type</label>
                            <div class="mt-2 relative">
                                <select id="propertyType" name="propertyType" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-6 grid grid-cols-7  gap-x-6 gap-y-8">
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
                            <label for="nameSuffix" class="block text-sm font-medium leading-6 text-gray-900">Name Suffix</label>
                            <div class="mt-2 relative">
                                <select id="nameSuffix" name="nameSuffix" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value=""></option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="Ph.D.">Ph.D.</option>
                                    <option value="M.D.">M.D.</option>
                                    <option value="MBA">MBA</option>
                                    <option value="CPA">CPA</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-6 grid grid-cols-7">
                        <div class="sm:col-span-6 grid grid-cols-6 gap-x-6 gap-y-8">
                            <div class="sm:col-span-2">
                                <label for="birthdate" class="block text-sm font-medium leading-6 text-gray-900">Birthday</label>
                                <div class="mt-2 relative">
                                    <div class="absolute top-0 left-0 inset-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input datepicker id="birthdate" name="birthdate" datepicker-autohide type="text" class="pl-10 block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="mm/dd/yyyy">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="age" class="block text-sm font-medium leading-6 text-gray-900">Age</label>
                                <div class="mt-2 relative">
                                    <input id="age" name="age" type="text" placeholder="Must be 18 years old or above." inputmode="numeric" pattern="[0-9]*" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" readonly disabled>
                                </div>
                                <div data-validate-input="age" class="validate-message"></div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="gender" class="block text-sm font-medium leading-6 text-gray-900">Gender</label>
                                <div class="mt-2 relative">
                                    <select id="gender" name="gender" class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-6 grid grid-cols-7 gap-x-6 gap-y-8">
                        <div class="sm:col-span-4 grid grid-cols-6 gap-x-6 gap-y-8">
                            <div class="sm:col-span-3">
                                <label for="phone_number" class="block text-sm font-medium leading-6 text-gray-900">Contact Number</label>
                                <div class="mt-2 relative">
                                    <input data-input-state="error" id="phone_number" name="phoneNumber" type="text" inputmode="numeric" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                </div>
                                <div data-validate-input="phoneNumber" class="validate-message"></div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                                <div class="mt-2 relative">
                                    <input data-input-state="error" id="email" name="email" type="email" autocomplete="email" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                </div>
                                <div data-validate-input="email" class="validate-message"></div>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-6 gap-x-6 gap-y-8">
                        <div class="sm:col-span-6 grid grid-cols-7 gap-x-6 gap-y-8">
                            <div class="sm:col-span-2">
                                <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
                                <div class="mt-2 relative">
                                    <input data-input-state="error" type="text" name="streetAddress" id="street-address" class="validate-input block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">

                                </div>
                                <div data-validate-input="streetAddress" class="validate-message"></div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="brgy" class="block text-sm font-medium leading-6 text-gray-900">Barangay</label>
                                <div class="mt-2 relative">
                                    <select id="brgy" name="brgy" class="add_client_address block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sm:col-span-6 gap-x-6 gap-y-8">
                        <div class="sm:col-span-6 grid grid-cols-7 gap-x-6 gap-y-8">
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
                </div>
            </div>

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Requirements</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Present a valid documents to verify the identity.</p>

                <div class="mt-10 space-y-10">
                    <fieldset>
                        <legend class="text-sm font-semibold leading-6 text-gray-900">Documents</legend>
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
                                    <input id="proofOfOwnership" name="proofOfOwnership" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="proofOfOwnership" class="font-medium text-gray-900"><span class="font-bold text-primary-600">Proof of Ownership</span> <br>
                                        <p class="text-gray-500">Presented a photocopy of Original Certificate of Title.</p>
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

            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <!-- <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button> -->
            <button id="submit-application" type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600" disabled>
                Submit
            </button>
        </div>
    </form>
</div>
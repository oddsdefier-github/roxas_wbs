<div class="flex flex-col gap-5">
    <div class="grid grid-cols-12 gap-x-6 w-full">
        <div class="col-span-12 md:col-span-3 bg-white shadow-sm p-4 rounded-md">
            <div class="flex justify-between">
                <div>
                    <div>
                        <h2 class="font-semibold text-gray-500 text-lg">
                            Total Clients
                        </h2>
                    </div>
                    <div class="py-5 flex gap-2 items-end">
                        <h1 id="total_clients" class="font-bold text-3xl"></h1>
                    </div>
                </div>
                <div class="h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between items-center gap-2 w-full text-lg">
                <div>
                    <p><span class="text-gray-600">Active: </span><span id="active_clients" class="font-semibold text-green-400"></span></p>
                </div>
                <div>
                    <p><span class="text-gray-600">Inactive: </span><span id="inactive_clients" class="font-semibold text-red-400"></span></p>
                </div>
                <div>
                    <p><span class="text-gray-600">Under Review: </span><span id="under_review_clients" class="font-semibold text-yellow-400"></span></p>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-3 bg-white shadow-sm p-4 rounded-md">
            <div class="flex justify-between">
                <div>
                    <div>
                        <h2 class="font-semibold text-gray-500 text-lg">
                            Total Revenue
                        </h2>
                    </div>
                    <div class="py-5">
                        <h1 id="total_revenue" class="font-bold text-3xl"></span>
                    </div>
                </div>
                <div class="h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                        <path d="M12 7v10" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between items-center gap-2 w-full">
                <div>
                    <p><span class="text-gray-500">Application: </span><span id="application_rev" class="font-semibold">6969</span></p>
                </div>
                <div>
                    <p><span class="text-gray-500">Billing: </span><span id="billing_rev" class="font-semibold">6969</span></p>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-3 bg-white shadow-sm p-4 rounded-md">
            <div class="flex justify-between">
                <div>
                    <div>
                        <h2 class="font-semibold text-gray-500 text-lg">
                            Total Application
                        </h2>
                    </div>
                    <div class="py-5 flex gap-2 items-end">
                        <h1 id="total_application" class="font-bold text-3xl"></h1>
                    </div>
                </div>
                <div class="h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                        <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between items-center gap-2 w-full">
                <div>
                    <p><span class="text-gray-500">Unconfirmed: </span><span id="unconfirmed_app" class="font-semibold">6969</span></p>
                </div>
                <div>
                    <p><span class="text-gray-500">Approved: </span><span id="approved_app" class="font-semibold">6969</span></p>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-3 bg-white shadow-sm p-4 rounded-md">
            <div class="flex justify-between">
                <div>
                    <div>
                        <h2 class="font-semibold text-gray-500 text-lg">
                            Total Consumption
                        </h2>
                    </div>
                    <div class="py-5 flex gap-2 items-end">
                        <h1 id="total_consumption" class="font-bold text-3xl">10000</h1>
                        <h1 class=" text-2xl text-gray-300">m³</h1>
                    </div>
                </div>
                <div class="h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 3.2a9 9 0 1 0 10.8 10.8a1 1 0 0 0 -1 -1h-6.8a2 2 0 0 1 -2 -2v-7a.9 .9 0 0 0 -1 -.8" />
                        <path d="M15 3.5a9 9 0 0 1 5.5 5.5h-4.5a1 1 0 0 1 -1 -1v-4.5" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between items-center gap-2 w-full">
                <div>
                    <p><span class="text-gray-500">Commercial: </span><span id="commercial_consumption" class="font-semibold">6969</span></p>
                </div>
                <div>
                    <p><span class="text-gray-500">Residential: </span><span id="residential_consumption" class="font-semibold">6969</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-x-6 w-full">
        <div class="col-span-12 xl:col-span-6 shadow-sm bg-white">
            <div class="">
                <div class="p-4 mb-4 flex flex-row gap-2 items-start pb-4 border-b border-gray-200">
                    <div class="p-2 h-full rounded-md outline-gray-200 bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-gray-500 w-10 h-10" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                        </svg>
                    </div>
                    <span class="flex flex-col gap-1">
                        <h1 class="text-xl font-bold text-gray-500">
                            Clients
                        </h1>
                        <h5 class="text-gray-400">
                            Percentage of clients per barangay.
                        </h5>
                    </span>
                </div>
                <div id="pie-chart" class="p-4 flex justify-center items-center h-full"></div>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-6 shadow-sm bg-white">
            <div class="">
                <div class="p-4 mb-4 flex flex-row gap-2 items-start pb-4 border-b border-gray-200">
                    <div class="p-2 h-full rounded-md outline-gray-200 bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-gray-500 w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                    <span class="flex flex-col gap-1">
                        <h1 class="text-xl font-bold text-gray-500">
                            Revenue
                        </h1>
                        <h5 class="text-gray-400">
                            Revenue generated by the system.
                        </h5>
                    </span>
                </div>
                <div id="barchart" class="p-4">
                </div>
            </div>
        </div>

        <div class="mt-5 col-span-12 xl:col-span-6 shadow-sm bg-white">
            <div class="">
                <div class="">
                    <div class="p-4 mb-4 flex flex-row gap-2 items-start pb-4 border-b border-gray-200">
                        <div class="p-2 h-full rounded-md outline-gray-200 bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-gray-500 w-10 h-10" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7.502 19.423c2.602 2.105 6.395 2.105 8.996 0c2.602 -2.105 3.262 -5.708 1.566 -8.546l-4.89 -7.26c-.42 -.625 -1.287 -.803 -1.936 -.397a1.376 1.376 0 0 0 -.41 .397l-4.893 7.26c-1.695 2.838 -1.035 6.441 1.567 8.546z" />
                            </svg>
                        </div>
                        <span class="flex flex-col gap-1">
                            <h1 class="text-xl font-bold text-gray-500">
                                Consumption
                            </h1>
                            <h5 class="text-gray-400">
                                Consumption trends based on monthly usage.
                            </h5>
                        </span>
                    </div>
                    <div id="line-chart" class="p-4"></div>
                </div>
            </div>
        </div>
    </div>